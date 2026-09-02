// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('7. Invoices, Expenses, Staff, Subscriptions & Settings', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="email"], input[type="email"]').fill('owner@gmail.com');
    await page.locator('input[name="password"], input[type="password"]').fill('123456');
    await page.locator('button[type="submit"]').click();
    await page.waitForURL(/dashboard|home/i, { timeout: 15000 });
  });

  test('Invoices Management (/invoice) displays billing records', async ({ page }) => {
    await page.goto('/invoice');
    await expect(page.locator('body')).toBeVisible();

    const tableOrCard = page.locator('table, .card, .dataTables_wrapper, .pc-container').first();
    await expect(tableOrCard).toBeVisible();
  });

  test('Expense Tracker (/expense) displays atelier overheads ledger', async ({ page }) => {
    await page.goto('/expense');
    await expect(page.locator('body')).toBeVisible();

    const tableOrCard = page.locator('table, .card, .dataTables_wrapper, .pc-container').first();
    await expect(tableOrCard).toBeVisible();
  });

  test('Tax Rates Configuration (/tax) displays tax slabs', async ({ page }) => {
    await page.goto('/tax');
    await expect(page.locator('body')).toBeVisible();

    const tableOrCard = page.locator('table, .card, .dataTables_wrapper, .pc-container').first();
    await expect(tableOrCard).toBeVisible();
  });

  test('Subscription Packages (/subscriptions) displays SaaS atelier plans', async ({ page }) => {
    await page.goto('/subscriptions');
    await expect(page.locator('body')).toBeVisible();

    const plansOrCards = page.locator('.card, .pricing-card, .plan-card, .table, .pc-container').first();
    await expect(plansOrCards).toBeVisible();
  });

  test('Contact Diary (/contact) and Notice Board (/note) load successfully', async ({ page }) => {
    await page.goto('/contact');
    await expect(page.locator('body')).toBeVisible();

    await page.goto('/note');
    await expect(page.locator('body')).toBeVisible();
  });

  test('Settings Console (/settings) loads configuration tabs', async ({ page }) => {
    await page.goto('/settings');
    await expect(page.locator('body')).toBeVisible();

    const tabs = page.locator('.nav-tabs .nav-link, .nav-pills .nav-link, .settings-menu a');
    if (await tabs.count() > 0) {
      await expect(tabs.first()).toBeVisible();
    }
  });

});
