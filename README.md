# 🪡 DarziDesk - Tailor Shop Management System & Customer Marketplace

**DarziDesk** is an all-in-one, enterprise-grade **Tailor Management System (TMS)** and **Customer Discovery Marketplace**. Built with **Laravel 9** on the backend and **Flutter** on the frontend, DarziDesk empowers tailor shop owners to automate their daily operations—from body measurements and Kanban production workflows to POS billing, inventory tracking, and tailor staff payout ledgers—while giving customers a seamless marketplace to discover nearby tailors, book fitting appointments, and track custom orders in real time.

---

## 🌟 Table of Contents

- [Key Features](#-key-features)
  - [🛍️ Customer Discovery Marketplace & Portal (B2C)](#️-customer-discovery-marketplace--portal-b2c)
  - [💼 Shop Owner & Operations Management (B2B)](#-shop-owner--operations-management-b2b)
  - [📊 Financials, Billing & Reports](#-financials-billing--reports)
  - [🛠️ Inventory, Production & Staff Management](#️-inventory-production--staff-management)
- [📱 Flutter Mobile & Web App Architecture](#-flutter-mobile--web-app-architecture)
- [🏗️ System Architecture & Workflow](#️-system-architecture--workflow)
- [🗄️ Database Schema & Models](#️-database-schema--models)
- [🔌 Complete API Documentation](#-complete-api-documentation)
- [🌐 Multi-Language Support](#-multi-language-support)
- [⚙️ Installation & Developer Guide](#️-installation--developer-guide)
- [🔐 Security & Compliance](#-security--compliance)
- [🚀 Future Innovations & Roadmap](#-future-innovations--roadmap)
  - [🤖 AI & Computer Vision Innovations](#-ai--computer-vision-innovations)
  - [🛍️ Customer Experience & Marketplace Evolution](#️-customer-experience--marketplace-evolution)
  - [💼 Shop Operations & B2B Workflow Optimization](#-shop-operations--b2b-workflow-optimization)
  - [📊 Logistics & Financial Infrastructure](#-logistics--financial-infrastructure)
  - [🔐 Security & Architectural Integrity](#-security--architectural-integrity)
- [📄 License](#-license)

---

## 🚀 Key Features

### 🛍️ Customer Discovery Marketplace & Portal (B2C)
- **Customer Self-Registration**: End-customers can sign up using email or phone number.
- **Tailor Shop Discovery Marketplace**:
  - **Featured Tailors**: Highlighted top-rated and promoted tailor shops.
  - **Nearby Tailors**: Search and filter tailor shops by city, postal code, or geolocation radius.
  - **Best Rated Tailors**: Ranked by customer ratings and verified completed order counts.
  - **Service Specialty Filters**: Quick filtering by garment types (Suits & Tuxedos, Traditional Wear, Shirts & Trousers, Alterations, Custom Embroidery).
- **Tailor Profile & Services Catalog**:
  - Detailed shop profile with banner, logo, business hours, address, and instant WhatsApp chat link.
  - Service price list with starting costs (e.g. 2-Piece Suit, Sherwani, Shirt) and estimated turnaround times.
  - Photo gallery of past custom tailoring work & customer review scores.
- **Appointment & Fitting Session Booking**:
  - Select service, date, time slot, and add custom fitting requests.
  - Real-time notification and appointment tracking (`Pending` ➔ `Confirmed` ➔ `Fitting Done` ➔ `Completed`).
- **Live Order Progress Tracker**:
  - Visual status stepper: `Order Placed` ➔ `Cutting` ➔ `Stitching` ➔ `Trial / Fitting` ➔ `Ready` ➔ `Delivered`.
- **Saved Body Measurements & History**:
  - View personal body measurements (Chest, Waist, Inseam, Shoulder, Sleeve, etc.) recorded by tailors over time.
- **Digital Invoices & Receipts**:
  - Access itemized invoices, view payment status (Paid, Partial, Unpaid), and download PDF receipts.

---

### 💼 Shop Owner & Operations Management (B2B)
- **Executive Dashboard**: Real-time sales summary, active orders counter, monthly revenue charts, pending trial alerts, and low material stock warnings.
- **Order Management**: Create & edit custom orders, assign cloth types, trial dates, delivery deadlines, and tracking tokens.
- **Kanban Production Board**: Drag-and-drop production pipeline across custom stages (`Pending`, `Cutting`, `Stitching`, `Quality Check`, `Ready`).
- **QR Code & Garment Scanning**: Print garment tags with QR codes to quickly scan orders during production stages.
- **Measurement Management**:
  - Custom measurement templates per cloth type (Men's Suit, Kurta, Dress, Pants, Shirt).
  - Body shape tags, posture notes, and fitting photo attachments.
  - Full versioned **Measurement Change History** to track body dimension changes over time.
- **Multi-Branch Management**: Create and manage multiple tailor shop branches with seamless active branch switching and data isolation.

---

### 📊 Financials, Billing & Reports
- **Point of Sale (POS) Checkout**: Fast counter checkout, multi-item selection, coupon discounts, tax calculation, and split payment modes (Cash, Card, UPI, Online).
- **Invoice & Receipt Generation**: Instant digital receipt generation, PDF download, and WhatsApp/SMS delivery.
- **Financial Analytics & P&L Reports**:
  - Yearly Profit & Loss statements.
  - Income and Expense breakdown charts.
  - Order volume and turnaround time reports.
- **Expense Tracking**: Categorized expense logs (Rent, Equipment, Thread/Buttons, Utilities) with vendor receipt uploads.

---

### 🛠️ Inventory, Production & Staff Management
- **Material & Fabric Inventory**: Track fabric rolls, buttons, zippers, thread counts, restock thresholds, and auto-deduction per order.
- **Tailor Staff Ledger & Payout Settlement**:
  - Track piece-rate labor pay earned per stitched garment item.
  - Record cash advances given to tailor workers.
  - One-click payout settlement processing with detailed transaction logs.
- **Role-Based Access Control (RBAC)**: Fine-grained permissions using Spatie Permissions (`super admin`, `owner`, `manager`, `tailor/employee`, `customer`).
- **WhatsApp & SMS Automation**: Automated WhatsApp notifications triggered on order status changes or appointment confirmations.

---

## 📱 Flutter Mobile & Web App Architecture

The frontend application (`darzidesk_app`) is built with **Flutter 3.x** and supports iOS, Android, and Web with responsive web design.

```
darzidesk_app/lib/
├── config/             # Theme tokens, colors, API endpoints, constants
├── models/             # Data models (Order, Customer, Measurement, Invoice, etc.)
├── providers/          # Provider State Management (Auth, Order, Marketplace, CustomerPortal, etc.)
├── screens/
│   ├── auth/           # Login, Register, Forgot Password, Reset Password
│   ├── customer/       # Customer Portal (Marketplace Explore, My Orders, Appointments, Measurements)
│   ├── dashboard/      # Shop Owner Admin Dashboard
│   ├── orders/         # Order List, Create/Edit Order, Tracking
│   ├── production/     # Kanban Board & Worker Assignments
│   ├── measurements/   # Measurement Forms & History
│   ├── pos/            # Point of Sale Checkout
│   ├── financials/     # Financial Analytics & P&L Reports
│   └── settings/       # App Settings & Branch Switcher
├── services/           # ApiService (HTTP client, Sanctum Token Storage)
├── utils/              # Formatters, Validators, Helpers
└── widgets/            # Reusable UI Components (Cards, Buttons, Modals, Steppers)
```

---

## 🏗️ System Architecture & Workflow

```
                                  ┌────────────────────────────────┐
                                  │       DarziDesk Platform       │
                                  └───────────────┬────────────────┘
                                                  │
                 ┌────────────────────────────────┴────────────────────────────────┐
                 │                                                                 │
  ┌──────────────────────────────┐                                  ┌──────────────────────────────┐
  │  B2B Tailor Shop Ecosystem  │                                  │   B2C Customer Marketplace   │
  ├──────────────────────────────┤                                  ├──────────────────────────────┤
  │ - Executive Dashboard        │                                  │ - Customer Self-Registration │
  │ - Kanban Production Board    │                                  │ - Shop Discovery (Nearby/Top)│
  │ - QR Code Garment Tags       │                                  │ - Service & Price Catalogs   │
  │ - Tailor Staff Payout Ledger │                                  │ - Fitting Appointment Book   │
  │ - POS Counter & Invoicing    │                                  │ - Live Order Status Stepper  │
  │ - Material Inventory & P&L   │                                  │ - Saved Body Measurements    │
  └──────────────┬───────────────┘                                  └──────────────┬───────────────┘
                 │                                                                 │
                 └────────────────────────────────┬────────────────────────────────┘
                                                  │
                                                  ▼
                                 ┌──────────────────────────────────┐
                                 │   Laravel 9 REST API Backend     │
                                 │   Sanctum Auth & RBAC Security   │
                                 └────────────────┬─────────────────┘
                                                  │
                                                  ▼
                                 ┌──────────────────────────────────┐
                                 │   Database & Storage Engine      │
                                 │   (MySQL / PostgreSQL / S3)      │
                                 └──────────────────────────────────┘
```

---

## 🗄️ Database Schema & Models

DarziDesk features a comprehensive database relational structure:

| Model | Table Name | Purpose | Key Attributes |
|---|---|---|---|
| `User` | `users` | All system users (Owners, Staff, Customers) | `name`, `email`, `type`, `phone_number`, `parent_id`, `is_active` |
| `Customer` | `customers` | Extended profile for customers | `user_id`, `body_shape`, `posture_notes`, `fitting_photo`, `address` |
| `Order` | `orders` | Main tailoring orders | `order_id`, `customer_id`, `status`, `production_stage_id`, `deadline_date`, `tracking_token` |
| `ProductionStage` | `production_stages` | Custom Kanban stages | `name`, `color`, `order_index`, `parent_id` |
| `ProductionAssignment`| `production_assignments` | Tailor worker assignments | `order_id`, `assigned_to`, `stage_id`, `status`, `piece_rate` |
| `Measurement` | `measurements` | Body measurements | `customer_id`, `cloth_type_id`, `measurements_json` |
| `MeasurementHistory` | `measurement_histories` | Versioned dimension logs | `customer_id`, `field_name`, `old_value`, `new_value`, `created_at` |
| `Material` | `materials` | Fabric & accessory stock | `name`, `sku`, `category`, `stock_quantity`, `unit`, `min_stock_alert` |
| `Invoice` | `invoices` | Billing & payment records | `invoice_id`, `order_id`, `total_amount`, `paid_amount`, `payment_status` |
| `TailorLedger` | `tailor_ledgers` | Labor wages & advances | `tailor_id`, `type` (`earnings`/`advance`/`payout`), `amount`, `notes` |
| `Appointment` | `appointments` | Fitting sessions | `customer_id`, `tailor_id`, `appointment_date`, `time_slot`, `status` |
| `Branch` | `branches` | Multi-store branches | `name`, `code`, `address`, `phone`, `parent_id` |

---

## 🔌 Complete API Documentation

All API endpoints are prefixed with `/api` and utilize Laravel Sanctum token authentication.

### Authentication & Profile
- `POST /api/login` - User authentication.
- `POST /api/register` - Shop owner registration.
- `POST /api/register/customer` - Customer self-registration.
- `POST /api/forgot-password` - Request password reset link.
- `POST /api/reset-password` - Reset account password.
- `GET /api/profile` - Fetch authenticated user profile.
- `POST /api/profile` - Update profile information.
- `POST /api/change-password` - Change account password.

### Marketplace & Shop Discovery (Public)
- `GET /api/marketplace/shops` - List tailor shops (Featured, Nearby, Best Rated).
- `GET /api/marketplace/shops/{id}` - Get detailed shop profile, service list, and gallery.
- `GET /api/marketplace/categories` - List garment service categories.

### Customer Portal (Authenticated Customers)
- `GET /api/customer/orders` - View customer's active & past orders.
- `GET /api/customer/measurements` - View saved body measurements & fitting history.
- `GET /api/customer/invoices` - View digital invoices & download receipts.
- `GET /api/customer/appointments` - List scheduled fitting appointments.
- `POST /api/customer/appointments` - Book new trial/fitting session.

### Shop Operations & Management (Authenticated Owners/Staff)
- `GET /api/dashboard` - Executive dashboard statistics.
- `GET /api/orders` - List all shop orders with status filters.
- `POST /api/orders` - Create a new custom order.
- `GET /api/orders/{id}` - View order details & itemized pricing.
- `PUT /api/orders/{id}` - Update order details.
- `PATCH /api/orders/{id}/status` - Update order production status.
- `GET /api/measurements` - List customer measurements.
- `POST /api/measurements` - Save customer measurements.
- `GET /api/customers` - List shop customers.
- `POST /api/customers` - Add new customer profile.
- `GET /api/invoices` - View all invoices.
- `POST /api/pos/store` - Process POS checkout & print invoice.
- `GET /api/production/kanban` - Fetch Kanban board production columns & cards.
- `POST /api/production/stage-update` - Move order card across Kanban stages.
- `GET /api/tailor-ledger` - Fetch tailor labor earnings, advances, and balance logs.
- `POST /api/tailor-ledger/settle` - Process tailor payout settlement.
- `GET /api/materials` - List fabric & material inventory.
- `POST /api/materials/{id}/restock` - Add inventory stock restock entry.
- `GET /api/reports/yearly-profit-loss` - Generate yearly P&L financial analysis.

---

## 🌐 Multi-Language Support

DarziDesk includes full internationalization (i18n) support across 12 languages:

- 🇬🇧 English (`en`)
- 🇮🇳 Hindi (`hi`)
- 🇪🇸 Spanish (`es`)
- 🇨🇳 Chinese (`zh`)
- 🇦🇪 Arabic (`ar`)
- 🇧🇩 Bengali (`bn`)
- 🇵🇹 Portuguese (`pt`)
- 🇫🇷 French (`fr`)
- 🇷🇺 Russian (`ru`)
- 🇯🇵 Japanese (`ja`)
- 🇵🇰 Urdu (`ur`)
- 🇩🇪 German (`de`)

All translatable strings are configured in `darzidesk_app/assets/translations/`.

---

## ⚙️ Installation & Developer Guide

### Prerequisites
- **PHP**: `>= 8.1`
- **Composer**: `>= 2.0`
- **Node.js**: `>= 16.x`
- **MySQL / PostgreSQL**: `>= 8.0` / `>= 13`
- **Flutter SDK**: `>= 3.19.0`

### 1. Backend Installation (Laravel API)
```bash
# Clone the repository
git clone https://github.com/your-username/darzidesk-tms.git
cd darzidesk-tms

# Install PHP dependencies
composer install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=darzidesk_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Run database migrations & default seeders
php artisan migrate --seed

# Create storage symbolic link
php artisan storage:link

# Start development server
php artisan serve
```

### 2. Frontend Installation (Flutter Mobile & Web App)
```bash
# Navigate to flutter app directory
cd darzidesk_app

# Fetch Flutter dependencies
flutter pub get

# Run on Web (Chrome)
flutter run -d chrome

# Build Web Bundle
flutter build web --release

# Run on Mobile Emulator (iOS / Android)
flutter run
```

---

## 🔐 Security & Compliance

- **API Token Security**: Protected by Laravel Sanctum with bearer token validation and token expiration.
- **Two-Factor Authentication (2FA)**: Integrated Google 2FA (`pragmarx/google2fa-laravel`) for shop owner login security.
- **Data Isolation**: Strict `parent_id` scoping to prevent cross-tenant data access between tailor shops.
- **Input Sanitization & Validation**: Form validation on all API endpoints to prevent SQL injection and XSS attacks.

---

## 🚀 Future Innovations & Roadmap

### 🤖 AI & Computer Vision Innovations
- **Remote AI Body Measurement**: Utilize smartphone-based computer vision and pose estimation to automate customer dimension capturing from any location.
- **AR Virtual Try-On Experience**: Provide customers with high-fidelity 3D garment previews on personalized avatars generated from unique body metrics.
- **Intelligent Fabric & Style Engine**: An AI-driven recommendation system suggesting optimal textiles, palettes, and silhouettes based on physique, complexion, and historical preferences.

### 🛍️ Customer Experience & Marketplace Evolution
- **3D Visual Garment Customizer**: Interactive UI for real-time selection of lapels, buttons, pocket styles, and bespoke monogramming during the ordering process.
- **Loyalty & Tiered Referral Rewards**: Incentivize retention through points, cashback, and exclusive membership tiers like the VIP Tailoring Club.
- **Actionable Smart Notifications**: Advanced push alerts allowing users to approve mockups or confirm fitting schedules directly via interactive notification banners.

### 💼 Shop Operations & B2B Workflow Optimization
- **Automated Capacity Planning**: Dynamically regulate booking availability based on live personnel workload, machinery hours, and daily production throughput.
- **Outsourcing & Artisan Management**: Dedicated modules for tracking external specialized services, including embroidery artisans and commercial dyeing vendors.
- **NFC & RFID Asset Tracking**: Next-generation garment tracking utilizing NFC fabric tags for seamless tap-to-update status changes across the production floor.

### 📊 Logistics & Financial Infrastructure
- **Smart Purchase Order Automation**: Proactive inventory replenishment by automatically generating supplier orders when raw materials fall below designated thresholds.
- **Integrated Courier Logistics**: Seamless API connectivity with delivery partners like Dunzo or DHL for automated trial pickups and final order fulfillment.
- **Global Tax & Multi-Currency Support**: Sophisticated POS engine featuring automated regional tax splits (GST/VAT) and multi-currency transaction handling.

### 🔐 Security & Architectural Integrity
- **Offline-First Data Synchronization**: Reliable local caching via Hive or SQLite, ensuring uninterrupted measurement updates and Kanban transitions during connectivity gaps.
- **Enterprise Audit Governance**: Comprehensive logging of administrative actions, including invoice adjustments, stock corrections, and financial payout settlements.

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.
