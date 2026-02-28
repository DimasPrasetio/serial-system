import { cpSync, existsSync, mkdirSync, readdirSync, rmSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const projectRoot = path.resolve(__dirname, '..');

const copyJobs = [
    {
        from: path.join(projectRoot, 'public', 'assets', 'spline'),
        to: path.join(projectRoot, 'public', 'build', 'assets', 'spline'),
        label: 'Spline runtime assets',
    },
];

for (const job of copyJobs) {
    if (!existsSync(job.from)) {
        throw new Error(`${job.label} source not found: ${job.from}`);
    }

    mkdirSync(path.dirname(job.to), { recursive: true });
    rmSync(job.to, { recursive: true, force: true });
    cpSync(job.from, job.to, { recursive: true });

    const copiedFiles = readdirSync(job.to);
    console.log(`[copy-public-assets] ${job.label} copied: ${copiedFiles.join(', ')}`);
}
