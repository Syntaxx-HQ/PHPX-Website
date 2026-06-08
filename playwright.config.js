const { defineConfig, devices } = require('@playwright/test');

module.exports = defineConfig({
    testDir: './tests/e2e',
    timeout: 60000,
    expect: { timeout: 30000 },
    fullyParallel: false,
    workers: 1,
    reporter: 'line',
    use: {
        baseURL: 'http://127.0.0.1:9930',
        trace: 'retain-on-failure',
    },
    projects: [
        { name: 'chromium', use: { ...devices['Desktop Chrome'] } },
    ],
    webServer: {
        command: 'php -d opcache.enable=0 -S 127.0.0.1:9930 -t public public/index.php',
        url: 'http://127.0.0.1:9930/',
        reuseExistingServer: false,
        timeout: 30000,
    },
});
