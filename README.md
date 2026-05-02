# DarziDesk - Tailor Management System

DarziDesk is a comprehensive management solution designed specifically for tailoring businesses. It streamlines operations, from order tracking and measurement management to invoicing and payments.

## 🚀 Features

- **Dashboard**: Overview of business metrics, recent orders, and notifications.
- **Order Management**: Track orders through various stages (Pending, Processing, Completed, Delivered).
- **Measurement Management**: Store and manage customer measurements for different cloth types.
- **Customer Management**: Maintain a database of customers and their order history.
- **Invoicing & Payments**: Generate professional invoices and accept payments via Stripe or PayPal.
- **Role-Based Access Control**: Manage permissions for Admins, Owners, Employees, and Customers.
- **Multi-Language Support**: Exportable translatable strings for localization.
- **Security**: Google 2FA integration for enhanced account protection.
- **Notifications**: Twilio integration for SMS alerts and email notifications.

## 🛠 Tech Stack

- **Framework**: [Laravel 9](https://laravel.com/)
- **Database**: MySQL / PostgreSQL
- **Frontend**: Blade Templates, Laravel UI
- **Styling**: TailwindCSS
- **Key Packages**:
  - `spatie/laravel-permission`: Role and Permission management.
  - `stripe/stripe-php` & `srmklive/paypal`: Payment gateways.
  - `twilio/sdk`: SMS notification services.
  - `pragmarx/google2fa-laravel`: Two-factor authentication.
  - `anhskohbo/no-captcha`: Google Recaptcha.

## 📋 Prerequisites

- PHP >= 8.0.2
- Composer
- Node.js & NPM
- MySQL

## ⚙️ Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd darzidesk
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**:
   Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```

6. **Link Storage**:
   ```bash
   php artisan storage:link
   ```

7. **Compile Assets**:
   ```bash
   npm run dev
   ```

8. **Start Server**:
   ```bash
   php artisan serve
   ```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.







