// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('3. Executive Dashboard & Financial Analytics', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="email"], input[type="email"]').fill('owner@gmail.com');
    await page.locator('input[name="password"], input[type="password"]').fill('123456');
    await page.locator('button[type="submit"]').click();
    await page.waitForURL(/dashboard|home/i, { timeout: 15000 });
  });

  test('Dashboard loads KPIs, sidebar navigation, and quick links', async ({ page }) => {
    await page.goto('/dashboard');

    // Sidebar navigation check
    const sidebar = page.locator('.pc-sidebar, .sidebar, nav').first();
    await expect(sidebar).toBeVisible();

    // Main content layout container check
    const mainContent = page.locator('.pc-container').first();
    await expect(mainContent).toBeVisible();

    // Verify key action buttons (New Order, POS, etc.)
    const quickLinks = page.locator('a[href*="orders/create"], a[href*="pos"], a[href*="customer"]');
    await expect(quickLinks.first()).toBeVisible();
  });

  test('Income and Revenue Analytics drilldown loads successfully', async ({ page }) => {
    await page.goto('/income-data');
    await expect(page.locator('body')).toBeVisible();
    await expect(page.locator('table, .card, .dataTables_wrapper, .pc-container').first()).toBeVisible();
  });

  test('Expense and Cost Analysis drilldown loads successfully', async ({ page }) => {
    await page.goto('/expense-data');
    await expect(page.locator('body')).toBeVisible();
    await expect(page.locator('table, .card, .dataTables_wrapper, .pc-container').first()).toBeVisible();
  });

});
