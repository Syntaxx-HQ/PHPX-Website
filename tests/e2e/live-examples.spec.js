const { test, expect } = require('@playwright/test');

test('live examples in the showcase are interactive', async ({ page }) => {
    await page.goto('/examples');

    // Counter (useState)
    const counter = page.getByTestId('live-counter').first();
    await expect(counter).toHaveText('Count: 0', { timeout: 30000 });
    await counter.click();
    await expect(counter).toHaveText('Count: 1');

    // Controlled input (focus retention)
    const input = page.getByTestId('echo-input');
    await input.fill('hello');
    await expect(page.getByTestId('echo-output')).toHaveText('hello');

    // Todo (state + list + keyboard)
    await page.getByTestId('todo-input').fill('Write docs');
    await page.getByTestId('todo-add').click();
    await expect(page.getByTestId('todo-list')).toContainText('Write docs');
});
