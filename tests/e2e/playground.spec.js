const { test, expect } = require('@playwright/test');

test('the playground compiles and runs the edited code live', async ({ page }) => {
    await page.goto('/playground');

    // Wait for the WASM runtime to boot (the loader sets window.php when ready).
    await page.waitForFunction(() => window.php !== undefined, { timeout: 30000 });
    await page.waitForTimeout(800);

    // The textarea is upgraded to a syntax-highlighted CodeMirror editor.
    await expect(page.locator('.CodeMirror')).toBeVisible();

    // Run the default snippet: server compiles JSX -> PHP, browser evals + renders.
    await page.getByTestId('playground-run').click();

    const output = page.getByTestId('playground-output');
    const demo = output.locator('button');
    await expect(demo).toContainText('Count: 0', { timeout: 15000 });

    // The compiled-and-executed component is itself interactive.
    await demo.click();
    await expect(demo).toContainText('Count: 1');

    // Re-running compiles again and cleanly replaces the result — the transient
    // "Compiling..." text must not linger.
    await page.getByTestId('playground-run').click();
    await expect(demo).toContainText('Count: 0', { timeout: 15000 });
    await expect(output).not.toContainText('Compiling');
});
