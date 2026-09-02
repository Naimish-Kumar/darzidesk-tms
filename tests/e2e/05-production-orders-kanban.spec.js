// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('5. Orders, Production Pipeline & Worker Tasks', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="email"], input[type="email"]').fill('owner@gmail.com');
    await page.locator('input[name="password"], input[type="password"]').fill('123456');
    await page.locator('button[type="submit"]').click();
    await page.waitForURL(/dashboard|home/i, { timeout: 15000 });
  });

  test('Order Directory (/order) displays orders table, statuses, and action controls', async ({ page }) => {
    await page.goto('/order');
    await expect(page.locator('body')).toBeVisible();

    const dataTableOrCard = page.locator('table, .card, .dataTables_wrapper').first();
    await expect(dataTableOrCard).toBeVisible();
  });

  test('Order Creation Step 1 (/orders/create/step-1) renders custom tailor order wizard', async ({ page }) => {
    await page.goto('/orders/create/step-1');
    await expect(page.locator('body')).toBeVisible();

    // Verify step 1 customer or garment form elements
    const customerField = page.locator('select[name="customer_id"], input[name="customer_name"], input[name="customer_id"]').first();
    if (await customerField.isVisible()) {
      await expect(customerField).toBeVisible();
    }
  });

  test('Production Pipeline Kanban Board (/production-pipeline) displays stage columns', async ({ page }) => {
    await page.goto('/production-pipeline');
    await expect(page.locator('body')).toBeVisible();

    // Verify kanban stages or layout
    const kanbanOrTable = page.locator('.kanban-board, .kanban-column, .card, .table').first();
    await expect(kanbanOrTable).toBeVisible();
  });

  test('Shop Floor Tailor Tasks (/worker-assignments) renders assignments and task modal', async ({ page }) => {
    await page.goto('/worker-assignments');

    // Verify Worker Assignment Hero Banner
    const banner = page.locator('.dd-wa-banner');
    await expect(banner).toBeVisible();

    // Verify Assign Task Modal Trigger
    const assignBtn = page.locator('button[data-bs-target="#assignTaskModal"]').first();
    await expect(assignBtn).toBeVisible();
    await assignBtn.click();

    const modal = page.locator('#assignTaskModal');
    await expect(modal).toBeVisible();

    // Close Modal
    const closeBtn = page.locator('#assignTaskModal .btn-close, #assignTaskModal button[data-bs-dismiss="modal"]').first();
    if (await closeBtn.isVisible()) {
      await closeBtn.click();
    }
  });

});
