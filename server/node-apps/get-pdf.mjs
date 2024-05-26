import { launch } from 'puppeteer';

(async () => {
    const browser = await launch({ args: ['--no-sandbox'] });
    const page = await browser.newPage();

    await page.goto(process.argv[2], { waitUntil: 'networkidle2', timeout: 0 });

    const pdf = await page.pdf({ printBackground: true, format: 'A4', landscape: true });

    process.stdout.write(pdf);

    await browser.close();
})();
