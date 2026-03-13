import { access, readFile } from 'node:fs/promises';
import path from 'node:path';

const projectRoot = process.cwd();
const manifestPath = path.join(projectRoot, 'public', 'build', 'manifest.json');
const requiredStaticAssets = [
  path.join(projectRoot, 'public', 'build', 'assets', 'spline', 'company-profile-hero.splinecode'),
  path.join(projectRoot, 'public', 'build', 'assets', 'spline', 'spline-viewer-1.12.58.js'),
];

async function assertExists(filePath) {
  await access(filePath);
}

async function main() {
  await assertExists(manifestPath);

  const manifestRaw = await readFile(manifestPath, 'utf8');
  const manifest = JSON.parse(manifestRaw);
  const assetPaths = Object.values(manifest)
    .flatMap((entry) => {
      const files = [];

      if (entry.file) {
        files.push(path.join(projectRoot, 'public', 'build', entry.file));
      }

      if (Array.isArray(entry.css)) {
        for (const cssFile of entry.css) {
          files.push(path.join(projectRoot, 'public', 'build', cssFile));
        }
      }

      return files;
    });

  for (const filePath of [...assetPaths, ...requiredStaticAssets]) {
    await assertExists(filePath);
  }

  console.log('Release build artifacts verified.');
}

main().catch((error) => {
  console.error('Release build verification failed.');
  console.error(error instanceof Error ? error.message : error);
  process.exit(1);
});
