# 👑 DarziDesk: Super Admin Complete Feature & Operational Guide
*(Platform Owner / SaaS Master Dashboard)*

---

## 📌 Super Admin Role Ka Purpose Kya Hai?
**Super Admin** DarziDesk SaaS platform ka master owner hota hai. Super Admin ka role kisi single boutique ko manage karna nahi, balki **platform ke saare boutique owners (tenants), subscription plans, platform revenue, payment gateways aur system settings** ko centralized control karna hai.

---

## 📑 Feature-by-Feature Detailed Hinglish Guide

---

### 1. 📊 Super Admin Dashboard (Platform Command Center)

#### 🎯 Kya Hai? (What is this?)
Platform-wide executive overview screen jo poore DarziDesk ecosystem ka real-time data ek jagah dikhati hai.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Platform owner ko rozana yeh janne ke liye database open na karna pade ki kitne naye boutique register hue, kitni subscription income hui, aur system par kitna order load hai.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **Platform Metrics Grid**: 
  - `Boutique Owners`: Total registered tailor shop tenants.
  - `Active Packages`: Total active SaaS subscription plans.
  - `Transactions`: Total subscription payment transactions.
  - `Revenue`: Platform ki total collected SaaS fees.
  - `Total Clients`: Sabhi boutiques ke total end-customers ka count.
  - `Total Orders`: Platform par process huye total bespoke tailoring orders.
- **ApexCharts Monthly Graph**: Automatically plot karta hai ki kis month me kitne boutique onboard hue aur kitna revenue collect hua.
- **Recent Registrations & Transactions Tables**: Latest 5 onboarded boutiques aur latest 5 subscription payments live show karta hai.

#### 🚀 Business Fayda:
Ek hi glance me pata chal jata hai ki SaaS business grow ho raha hai ya drop, aur monthly MRR (Monthly Recurring Revenue) calculate karna aasan ho jata hai.

---

### 2. 🏪 Tenant & Boutique Management (`/users`)

#### 🎯 Kya Hai? (What is this?)
Platform par registered sabhi boutique shop owners ka master directory aur user management module.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Jab koi boutique owner sign-up karta hai, unhe plan assign karna, unka account activate/suspend karna, ya unke store details verify karna Super Admin ka kaam hota hai.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
1. **List All Tenants**: Sabhi boutique owners ki list (Name, Email, Shop Name, Assigned Plan, Expiration Date, Status) show hoti hai.
2. **Create New Tenant**: Agar koi boutique offline onboard hota hai, toh Super Admin manually unka account create karke login credentials email kar sakta hai.
3. **Upgrade / Assign Plan**: Super Admin kisi bhi boutique ka plan 1-click me upgrade (e.g. Free Trial se Enterprise) ya validity extend kar sakta hai.
4. **Account Suspension / Toggle**: Agar koi boutique terms violate kare ya subscription pay na kare, unka account deactivate kiya ja sakta hai.
5. **Login as Tenant (Impersonation)**: Support ke liye Super Admin tenant ke account me temporarily switch karke issue resolve kar sakta hai.

#### 🚀 Business Fayda:
Multi-tenant architecture 100% secure rehta hai, aur tenant onboarding friction-free ho jati hai.

---

### 3. 💳 SaaS Pricing Packages & Subscriptions (`/subscriptions`)

#### 🎯 Kya Hai? (What is this?)
DarziDesk ke monetization plans (e.g. Starter, Pro, Enterprise Boutique Plan) create aur manage karne ka engine.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Alag-alag size ke tailoring shops (chhote single-tailor shop se lekar multi-branch luxury designer atelier) ke hisab se custom pricing aur feature limits set karna zaroori hai.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **Package Creation Options**:
  - `Package Name`: E.g. "Boutique Pro Plan".
  - `Price`: Monthly ya Yearly fee (e.g. ₹999/month ya $29/month).
  - `Duration`: Days / Months / Years.
  - `Max Users / Staff`: Kitne staff accounts allowed hain (e.g. 5 staff vs Unlimited).
  - `Max Customers / Orders`: Storage limits (e.g. 500 orders vs Unlimited).
  - `Feature Toggles`: Enabled modules (e.g. Multi-branch, WhatsApp Alerts, Advanced Analytics).
- **Public Display**: Ye plans automatically landing page (`/pricing`) par live show hote hain jahan se boutique owner online checkout kar sakta hai.

#### 🚀 Business Fayda:
Recurring SaaS subscription model se predictable monthly recurring revenue (MRR) generate hota hai.

---

### 4. 📜 Subscription Billing & Transactions (`/subscription/transaction`)

#### 🎯 Kya Hai? (What is this?)
Platform par huye har subscription payment ka transparent financial log.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Payment reconciliation, refund tracking, aur tax/audit reporting ke liye har online/offline transaction ka record hona mandatory hai.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Table me show hota hai:
  - `Transaction ID` & Payment Gateway Reference ID.
  - `Boutique Owner Name` & Registered Email.
  - `Plan Name` (Starter, Pro, Enterprise).
  - `Amount Paid` & Currency.
  - `Payment Method` (Stripe, Razorpay, Bank Transfer, PayPal).
  - `Payment Status` (Success, Pending Approval, Failed).
  - `Date & Timestamp`.
- **Manual Bank Transfer Approval**: Agar boutique owner ne bank transfer kiya hai aur slip upload ki hai, Super Admin yahan se 1-click me approve karke subscription activate kar sakta hai.

#### 🚀 Business Fayda:
0% revenue leakage aur direct automated invoice generation.

---

### 5. 🌐 Payment Gateways & Banking Config (`/setting` -> Payment Settings)

#### 🎯 Kya Hai? (What is this?)
Super Admin ke apne payment gateways configure karne ki settings taaki boutique owners ke subscription payments directly Super Admin ke bank account me transfer hon.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Global aur domestic boutique owners credit card, debit card, UPI, ya net banking se online pay kar saken.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Super Admin apni API keys set karta hai:
  - **Stripe**: `Publishable Key` aur `Secret Key` (Global Card Payments).
  - **Razorpay**: `Key ID` aur `Key Secret` (India UPI, Cards, NetBanking).
  - **PayPal**: `Client ID` aur `Secret` (International PayPal users).
  - **Offline Bank Transfer**: Bank Name, Account Number, IFSC/IBAN, Swift Code instructions.

#### 🚀 Business Fayda:
Instant payment processing aur automated subscription renewal without manual follow-up.

---

### 6. 🎨 Landing Page & Public CMS Builder (`/home-page-section`, `/footer-setting`, `/pages`)

#### 🎯 Kya Hai? (What is this?)
DarziDesk marketing website (`/`, `/about-us`, `/pricing`, `/segment`) ke text, banners, screenshots, aur content ko bina code edit kiye control karne ka CMS.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Marketing offers, festival discounts, new feature announcements, aur custom legal pages (Privacy Policy, Terms of Service) ko live website par instantly update karna.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **Hero & Slogan**: Headline, subheadline, aur CTA buttons change karna.
- **Feature Blocks**: "Why Choose DarziDesk" ke 6 features aur icons update karna.
- **App Download Showcase**: iOS/Android app store links aur screenshots configure karna.
- **Custom Pages**: Terms of Service, Privacy Policy, Refund Policy create/edit karna.
- **Footer Settings**: Social media links (Instagram, Facebook, LinkedIn), support email, aur phone number update karna.

#### 🚀 Business Fayda:
Marketing team bina developers ke website content 2 minute me update kar sakti hai.

---

### 7. ✍️ Blog & SEO Content Engine (`/blog/admin`)

#### 🎯 Kya Hai? (What is this?)
Boutique aur tailoring industry se related informative articles publish karne ka blogging engine.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Organic Google search ranking (SEO) improve karne ke liye taaki jab koi tailor *"Best tailoring software in India"* ya *"Boutique management app"* search kare, toh DarziDesk top par rank ho.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Super Admin Rich Text Editor se blog write karta hai (Title, Slug, Featured Image, Category, Tags, Meta Description, Content).
- Article automatically `/blog` index par aur individual URL `/blog/{slug}` par live publish ho jata hai.
- Auto-generated `<link rel="canonical">` aur Open Graph tags search engines ko feed hote hain.

#### 🚀 Business Fayda:
Zero advertising cost par high-intent organic tailoring clients attract hote hain.

---

### 8. ⚙️ System Settings, SMTP & 2FA Security (`/setting`)

#### 🎯 Kya Hai? (What is this?)
Platform-wide core configuration parameters: Email SMTP server, Company Logo, Default Currency, Timezone, aur Two-Factor Authentication (2FA).

#### 💡 Kyun Zaroori Hai? (Why this feature?)
System-generated emails (Password Reset, Subscription Invoice, Welcome Email) deliver hon aur platform secure rahe.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **SMTP Setup**: Host, Port, Username, Password aur Encryption (TLS/SSL) configure karke "Test Mail" button se live verify kiya jata hai.
- **Branding**: Super Admin DarziDesk ka dark/light logo aur favicon upload kar sakta hai.
- **2FA Security**: Super Admin accounts ke liye Google Authenticator OTP mandatory kiya ja sakta hai.

#### 🚀 Business Fayda:
High enterprise-grade security aur 100% reliable email delivery.
