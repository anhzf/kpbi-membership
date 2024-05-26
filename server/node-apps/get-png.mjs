import { launch } from 'puppeteer';

(async () => {
    const browser = await launch({ args: ['--no-sandbox'] });
    const page = await browser.newPage();

    await page.goto(process.argv[2], { waitUntil: 'networkidle2' });

    const png = await page.screenshot({ printBackground: true, format: 'A4', landscape: true });

    process.stdout.write(png);

    await browser.close();
})();
