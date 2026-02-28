const { test, expect } = require('@playwright/test');

test('home is server-rendered and hydrates to interactive', async ({ request, page }) => {
    // SSR-first: the raw HTML already contains the content + seed blob.
    const html = await (await request.get('/')).text();
    expect(html).toContain('Take back the web');
    expect(html).toContain('Count: 0');
    expect(html).toContain('__phpx_state__');

    // Then it boots WASM and hydrates: the counter becomes interactive.
    await page.goto('/');
    const counter = page.getByTestId('live-counter').first();
    await expect(counter).toHaveText('Count: 0', { timeout: 30000 });
    await counter.click();
    await expect(counter).toHaveText('Count: 1');
});

test('a docs page is server-rendered with sidebar and highlighted code', async ({ request }) => {
    const html = await (await request.get('/docs/getting-started')).text();
    expect(html).toContain('Getting Started');
    expect(html).toContain('data-testid="sidebar"');
    expect(html).toContain('language-php');
});
