const { test, expect } = require('@playwright/test');

test('sidebar navigates client-side without a full reload', async ({ page }) => {
    await page.goto('/docs/getting-started');
    await expect(page.getByTestId('doc-page')).toBeVisible({ timeout: 30000 });

    // Wait for hydration by confirming the live counter is interactive.
    const counter = page.getByTestId('live-counter').first();
    await counter.click();
    await expect(counter).toHaveText('Count: 1');

    // A sidebar link should navigate via the History API, not a page load.
    let reloaded = false;
    page.on('load', () => { reloaded = true; });

    await page.getByTestId('sidebar').getByRole('link', { name: 'useState', exact: true }).click();
    await expect(page).toHaveURL(/\/docs\/hooks\/use-state$/);
    await expect(page.getByRole('heading', { level: 1, name: 'useState' })).toBeVisible();
    expect(reloaded).toBe(false);
});
