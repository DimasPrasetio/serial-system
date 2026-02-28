import process from 'node:process';

const chromePort = Number(process.env.CHROME_DEBUG_PORT || 9222);
const targetUrl = process.argv[2];

if (!targetUrl) {
  console.error('Usage: node scripts/benchmark-public.mjs <url>');
  process.exit(1);
}

const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

async function waitForJson(url, attempts = 50) {
  for (let i = 0; i < attempts; i += 1) {
    try {
      const response = await fetch(url);
      if (response.ok) {
        return response.json();
      }
    } catch (error) {
      // Chrome may still be booting.
    }
    await sleep(200);
  }

  throw new Error(`Unable to reach ${url}`);
}

class CdpSession {
  constructor(endpoint) {
    this.socket = new WebSocket(endpoint);
    this.sequence = 0;
    this.pending = new Map();
    this.listeners = new Set();
    this.openPromise = new Promise((resolve, reject) => {
      this.socket.addEventListener('open', resolve, { once: true });
      this.socket.addEventListener('error', reject, { once: true });
    });

    this.socket.addEventListener('message', (event) => {
      const payload = JSON.parse(String(event.data));
      if (payload.id) {
        const handler = this.pending.get(payload.id);
        if (!handler) {
          return;
        }

        this.pending.delete(payload.id);
        if (payload.error) {
          handler.reject(new Error(payload.error.message));
        } else {
          handler.resolve(payload.result);
        }
        return;
      }

      for (const listener of this.listeners) {
        listener(payload);
      }
    });
  }

  async ready() {
    await this.openPromise;
  }

  onEvent(listener) {
    this.listeners.add(listener);
    return () => this.listeners.delete(listener);
  }

  send(method, params = {}, sessionId) {
    const id = ++this.sequence;
    const message = { id, method, params };
    if (sessionId) {
      message.sessionId = sessionId;
    }

    return new Promise((resolve, reject) => {
      this.pending.set(id, { resolve, reject });
      this.socket.send(JSON.stringify(message));
    });
  }

  close() {
    this.socket.close();
  }
}

async function main() {
  const version = await waitForJson(`http://127.0.0.1:${chromePort}/json/version`);
  const session = new CdpSession(version.webSocketDebuggerUrl);
  await session.ready();

  const { targetId } = await session.send('Target.createTarget', { url: 'about:blank' });
  const attached = await session.send('Target.attachToTarget', {
    targetId,
    flatten: true,
  });
  const cdpSessionId = attached.sessionId;

  const loadEvent = new Promise((resolve) => {
    const off = session.onEvent((payload) => {
      if (payload.sessionId === cdpSessionId && payload.method === 'Page.loadEventFired') {
        off();
        resolve();
      }
    });
  });

  await session.send('Page.enable', {}, cdpSessionId);
  await session.send('Runtime.enable', {}, cdpSessionId);
  await session.send('Performance.enable', {}, cdpSessionId);
  await session.send('Network.enable', {}, cdpSessionId);
  await session.send('Page.navigate', { url: targetUrl }, cdpSessionId);

  await loadEvent;
  await sleep(5000);

  const performanceMetrics = await session.send('Performance.getMetrics', {}, cdpSessionId);
  const runtimeResult = await session.send(
    'Runtime.evaluate',
    {
      awaitPromise: true,
      returnByValue: true,
      expression: `
        (async () => {
          const getPaint = (name) => performance.getEntriesByName(name)[0]?.startTime ?? null;
          let lcp = 0;
          let cls = 0;

          try {
            const lcpEntries = [];
            const lcpObserver = new PerformanceObserver((list) => {
              lcpEntries.push(...list.getEntries());
            });
            lcpObserver.observe({ type: 'largest-contentful-paint', buffered: true });

            const clsObserver = new PerformanceObserver((list) => {
              for (const entry of list.getEntries()) {
                if (!entry.hadRecentInput) {
                  cls += entry.value;
                }
              }
            });
            clsObserver.observe({ type: 'layout-shift', buffered: true });

            await new Promise((resolve) => setTimeout(resolve, 100));
            lcp = lcpEntries.reduce((max, entry) => Math.max(max, entry.startTime), 0);
            lcpObserver.disconnect();
            clsObserver.disconnect();
          } catch (error) {
            // Entry types may be unavailable in headless fallback modes.
          }

          const nav = performance.getEntriesByType('navigation')[0];
          const resources = performance.getEntriesByType('resource');

          return {
            title: document.title,
            navType: nav?.type ?? null,
            domContentLoaded: nav?.domContentLoadedEventEnd ?? null,
            loadEventEnd: nav?.loadEventEnd ?? null,
            transferSize: nav?.transferSize ?? null,
            encodedBodySize: nav?.encodedBodySize ?? null,
            decodedBodySize: nav?.decodedBodySize ?? null,
            firstPaint: getPaint('first-paint'),
            firstContentfulPaint: getPaint('first-contentful-paint'),
            largestContentfulPaint: lcp || null,
            cumulativeLayoutShift: cls,
            resourceCount: resources.length,
            resourceTransferSize: resources.reduce((sum, entry) => sum + (entry.transferSize || 0), 0),
            thirdPartyCount: resources.filter((entry) => {
              try {
                return new URL(entry.name, location.href).origin !== location.origin;
              } catch (error) {
                return false;
              }
            }).length,
            imageCount: document.images.length,
            sectionCount: document.querySelectorAll('section').length,
            revealCount: document.querySelectorAll('.gs-reveal').length,
          };
        })();
      `,
    },
    cdpSessionId,
  );

  const metrics = Object.fromEntries(
    performanceMetrics.metrics.map((entry) => [entry.name, entry.value]),
  );

  console.log(
    JSON.stringify(
      {
        url: targetUrl,
        browser: version['Browser'],
        page: runtimeResult.result.value,
        cdp: {
          jsHeapUsedSize: metrics.JSHeapUsedSize ?? null,
          jsHeapTotalSize: metrics.JSHeapTotalSize ?? null,
          nodes: metrics.Nodes ?? null,
          layoutCount: metrics.LayoutCount ?? null,
          recalcStyleCount: metrics.RecalcStyleCount ?? null,
          taskDuration: metrics.TaskDuration ?? null,
          scriptDuration: metrics.ScriptDuration ?? null,
          layoutDuration: metrics.LayoutDuration ?? null,
        },
      },
      null,
      2,
    ),
  );

  await session.send('Target.closeTarget', { targetId });
  session.close();
}

main().catch((error) => {
  console.error(error.stack || error.message);
  process.exit(1);
});
