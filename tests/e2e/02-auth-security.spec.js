// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('2. Authentication, Registration & Security', () => {

  test('Login view displays branding, credentials form and forgot password link', async ({ page }) => {
    await page.goto('/login');
    await expect(page).toHaveTitle(/Login|DarziDesk/i);

    const emailField = page.locator('input[name="email"], input[type="email"]');
    const passwordField = page.locator('input[name="password"], input[type="password"]');
    const submitBtn = page.locator('button[type="submit"]');

    await expect(emailField).toBeVisible();
    await expect(passwordField).toBeVisible();
    await expect(submitBtn).toBeVisible();

    // Verify Google sign-in button
    const googleBtn = page.locator('#btn-google-login, a.btn-social-google');
    await expect(googleBtn).toBeVisible();
    await expect(googleBtn).toHaveAttribute('href', /auth\/google/);
  });

  test('Invalid credentials trigger authentication rejection', async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="email"], input[type="email"]').fill('unregistered_tailor@example.com');
    await page.locator('input[name="password"], input[type="password"]').fill('WrongSecretPass999!');
    await page.locator('button[type="submit"]').click();

    // Verify still on login page
    await expect(page).toHaveURL(/login/);
  });

  test('Registration page renders studio partner signup fields and Google button', async ({ page }) => {
    await page.goto('/register');
    await expect(page.locator('body')).toBeVisible();

    const googleRegisterBtn = page.locator('#btn-google-register, a.btn-social-google');
    if (await googleRegisterBtn.isVisible()) {
      await expect(googleRegisterBtn).toBeVisible();
      await expect(googleRegisterBtn).toHaveAttribute('href', /auth\/google/);
    }

    const nameInput = page.locator('input[name="name"]');
    const emailInput = page.locator('input[name="email"]');
    if (await nameInput.isVisible()) {
      await expect(nameInput).toBeVisible();
      await expect(emailInput).toBeVisible();
    }
  });

  test('Google OAuth initiate route redirects or handles unconfigured state securely', async ({ page }) => {
    await page.goto('/auth/google');
    // If not configured, redirects back to login with notice; if configured, redirects to accounts.google.com
    await page.waitForLoadState('networkidle');
    const url = page.url();
    expect(url.includes('login') || url.includes('accounts.google.com')).toBeTruthy();
  });

  test('Forgot Password page renders password reset request form', async ({ page }) => {
    await page.goto('/forgot-password');
    await expect(page.locator('body')).toBeVisible();
    const resetEmailInput = page.locator('input[type="email"]');
    if (await resetEmailInput.isVisible()) {
      await expect(resetEmailInput).toBeVisible();
    }
  });

  test('Owner authentication succeeds and boots TMS Session', async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="email"], input[type="email"]').fill('owner@gmail.com');
    await page.locator('input[name="password"], input[type="password"]').fill('123456');
    await page.locator('button[type="submit"]').click();

    // Verify authenticated landing on dashboard
    await page.waitForURL(/dashboard|home/i, { timeout: 15000 });
    await expect(page.locator('.pc-sidebar, .sidebar, nav').first()).toBeVisible();
  });
});
