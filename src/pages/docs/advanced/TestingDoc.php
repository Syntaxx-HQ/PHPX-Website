<?php

function TestingDoc()
{
    $code = <<<'JS'
test('counter increments', async ({ page }) => {
    await page.goto('/');
    const button = page.getByTestId('counter');
    await button.click();
    await expect(button).toHaveText('Count: 1');
});
JS;

    return (
        <DocPage title="Testing" description="End-to-end tests with Playwright.">
            <p>
                Because a PHPX app runs in a real browser, end-to-end testing with Playwright is the
                natural fit. Add <code>data-testid</code> attributes to the elements you want to target.
            </p>
            <CodeBlock code={$code} language="javascript" />

            <Heading level={2} id="waiting">Waiting for the runtime</Heading>
            <p>
                The WASM runtime takes a moment to boot. Prefer assertions that poll - such as expecting
                an element to have text - over fixed delays.
            </p>

            <Callout type="tip" title="Console first">
                When something does not render, check the browser console before writing a test. Most
                problems show up there immediately.
            </Callout>
        </DocPage>
    );
}
