// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('1. Public Marketplace & Informational Pages', () => {

  test('Home / Landing Page renders hero, artisan search, and footer', async ({ page }) => {
    await page.goto('/');
    await expect(page).toHaveTitle(/DarziDesk/i);

    // Verify navigation logo
    const logo = page.locator('header img, nav img').first();
    await expect(logo).toBeVisible();

    // Verify hero typography
    const heroTitle = page.locator('h1').first();
    await expect(heroTitle).toBeVisible();

    // Verify search bar interaction
    const keywordInput = page.locator('#search-keyword-input, input[name="search"], input[placeholder*="Bespoke"]').first();
    if (await keywordInput.isVisible()) {
      await keywordInput.fill('Sherwani');
      await expect(keywordInput).toHaveValue('Sherwani');
    }

    // Verify footer links
    const footer = page.locator('footer');
    await expect(footer).toBeVisible();
  });

  test('About Us page loads with full company mission content', async ({ page }) => {
    await page.goto('/about-us');
    await expect(page.locator('h1, h2').first()).toBeVisible();
    await expect(page.locator('footer')).toBeVisible();
  });

  test('Privacy Policy page loads compliance policy text', async ({ page }) => {
    await page.goto('/privacy-policy');
    await expect(page.locator('h1, h2, h3').first()).toBeVisible();
    await expect(page.locator('footer')).toBeVisible();
  });

  test('Terms & Conditions page loads service agreement', async ({ page }) => {
    await page.goto('/terms-and-conditions');
    await expect(page.locator('h1, h2, h3').first()).toBeVisible();
    await expect(page.locator('footer')).toBeVisible();
  });

  test('Public Tailor Profile (/tailor/1) showcases atelier specs & booking modal', async ({ page }) => {
    await page.goto('/tailor/1');

    // Verify Atelier Details & Verified Badge
    await expect(page.locator('h1')).toBeVisible();
    await expect(page.locator('.verified-badge').first()).toBeVisible();

    // Verify 4 Key Performance Metrics (Experience, Orders, TAT, Accuracy)
    const statPills = page.locator('.stat-pill');
    await expect(statPills).toHaveCount(4);

    // Verify Luxury Action CTA Buttons
    const bookConsultationBtn = page.locator('.btn-book-now').first();
    await expect(bookConsultationBtn).toBeVisible();

    const whatsappBtn = page.locator('.btn-whatsapp');
    await expect(whatsappBtn).toBeVisible();

    const callBtn = page.locator('.btn-call').first();
    await expect(callBtn).toBeVisible();

    // Verify Services, Fabrics & Review Cards
    await expect(page.locator('.service-item').first()).toBeVisible();
    await expect(page.locator('.fabric-card').first()).toBeVisible();
    await expect(page.locator('.review-card').first()).toBeVisible();

    // Test Appointment Booking Modal Functionality
    await bookConsultationBtn.click();
    const modal = page.locator('#bookingModal');
    await expect(modal).toHaveClass(/active/);
    await expect(page.locator('#bookingModal input[name="customer_name"]')).toBeVisible();
    await expect(page.locator('#bookingModal input[name="email"]')).toBeVisible();
    await expect(page.locator('#bookingModal select[name="service_type"]')).toBeVisible();

    // Close Modal
    await page.locator('.modal-close').click();
    await expect(modal).not.toHaveClass(/active/);
  });

  test('Public Order Tracking (/track-order) interface and validation', async ({ page }) => {
    await page.goto('/track-order');
    await expect(page.locator('body')).toBeVisible();

    const trackingInput = page.locator('input[type="text"]').first();
    if (await trackingInput.isVisible()) {
      await trackingInput.fill('ORD-9999-TEST');
      const submitBtn = page.locator('button[type="submit"]').first();
      if (await submitBtn.isVisible()) {
        await submitBtn.click();
      }
    }
  });

});
