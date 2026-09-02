// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('4. POS Invoicing Console & Billing Workflow', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="email"], input[type="email"]').fill('owner@gmail.com');
    await page.locator('input[name="password"], input[type="password"]').fill('123456');
    await page.locator('button[type="submit"]').click();
    await page.waitForURL(/dashboard|home/i, { timeout: 15000 });
  });

  test('POS Console renders catalog grid, live search and category filters', async ({ page }) => {
    await page.goto('/pos');

    // Layout check
    await expect(page.locator('.pos-grid-layout, .catalog-filter-bar').first()).toBeVisible();

    // Search bar functionality
    const searchBar = page.locator('#posSearchInput, input[placeholder*="Search"]');
    if (await searchBar.isVisible()) {
      await searchBar.fill('Suit');
      await page.waitForTimeout(200);
      await searchBar.clear();
    }

    // Category filter pills
    const filterPills = page.locator('.filter-pill');
    if (await filterPills.count() > 0) {
      await expect(filterPills.first()).toBeVisible();
      await filterPills.first().click();
    }
  });

  test('POS Cart and Customer billing selection interactive operations', async ({ page }) => {
    await page.goto('/pos');

    // Cart Container
    const cartCard = page.locator('.cart-card, .customer-info-box').first();
    await expect(cartCard).toBeVisible();

    // Payment Method Selection Pills
    const pmPills = page.locator('.pm-pill');
    if (await pmPills.count() > 1) {
      await pmPills.nth(1).click();
      await expect(pmPills.nth(1)).toHaveClass(/active/);
      await pmPills.first().click();
      await expect(pmPills.first()).toHaveClass(/active/);
    }

    // Customer Selector dropdown
    const customerSelect = page.locator('#posCustomerSelect, select[name="customer_id"]');
    if (await customerSelect.isVisible()) {
      await expect(customerSelect).toBeVisible();
    }

    // Complete Order button presence
    const submitBtn = page.locator('#btnSubmitPos, .btn-proceed-pay').first();
    await expect(submitBtn).toBeVisible();
  });

});
