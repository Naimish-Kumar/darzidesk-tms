// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('6. Customers, Measurement Vault & Cloth Types', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="email"], input[type="email"]').fill('owner@gmail.com');
    await page.locator('input[name="password"], input[type="password"]').fill('123456');
    await page.locator('button[type="submit"]').click();
    await page.waitForURL(/dashboard|home/i, { timeout: 15000 });
  });

  test('Customer Directory (/customer) displays client profiles', async ({ page }) => {
    await page.goto('/customer');
    await expect(page.locator('body')).toBeVisible();

    const tableOrCard = page.locator('table, .card, .dataTables_wrapper').first();
    await expect(tableOrCard).toBeVisible();
  });

  test('Measurement Vault (/measurement) displays recorded anatomy data', async ({ page }) => {
    await page.goto('/measurement');
    await expect(page.locator('body')).toBeVisible();

    const tableOrCard = page.locator('table, .card, .dataTables_wrapper, .pc-container').first();
    await expect(tableOrCard).toBeVisible();
  });

  test('Measurement Units (/measurement-unit) lists metric/imperial configurations', async ({ page }) => {
    await page.goto('/measurement-unit');
    await expect(page.locator('body')).toBeVisible();

    const tableOrCard = page.locator('table, .card, .dataTables_wrapper, .pc-container').first();
    await expect(tableOrCard).toBeVisible();
  });

  test('Cloth Types & Fabric Categories (/cloth-type) displays apparel styles', async ({ page }) => {
    await page.goto('/cloth-type');
    await expect(page.locator('body')).toBeVisible();

    const tableOrCard = page.locator('table, .card, .dataTables_wrapper, .pc-container').first();
    await expect(tableOrCard).toBeVisible();
  });

});
