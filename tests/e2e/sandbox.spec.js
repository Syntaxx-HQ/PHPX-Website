const { test, expect } = require('@playwright/test');

test('the features sandbox swaps the live preview between demos', async ({ page }) => {
    await page.goto('/features');

    // Tab 0 is the Counter — wait for hydration, confirm it is interactive.
    const counter = page.getByTestId('live-counter');
    await expect(counter).toBeVisible({ timeout: 30000 });
    await counter.click();
    await expect(counter).toHaveText('Count: 1');

    // Switch to the Toggle demo — the preview should swap.
    await page.getByTestId('sandbox-tab-1').click();
    await expect(page.getByTestId('toggle-btn')).toBeVisible();
    await expect(page.getByTestId('live-counter')).toHaveCount(0);

    // The swapped-in demo is itself interactive.
    await page.getByTestId('toggle-btn').click();
    await expect(page.getByTestId('toggle-btn')).toHaveText('ON');
});
