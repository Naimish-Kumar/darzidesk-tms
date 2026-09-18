# 👔 DarziDesk: Boutique Owner Complete Feature & Operational Guide
*(Boutique Owner / Master Tailor / Shop Admin Dashboard)*

---

## 📌 Boutique Owner Role Ka Purpose Kya Hai?
**Boutique Owner** DarziDesk tenant account ka primary administrator hota hai. Boutique Owner ka kaam apne tailored studio, designer boutique, ya tailoring factory ke har ek operation ko digitally streamline karna hai — **Customer Measurements se lekar POS Billing, Karigar Wages, Production Kanban, Fabric Inventory aur WhatsApp Updates tak**.

---

## 📑 Feature-by-Feature Detailed Hinglish Guide

---

### 1. 📊 Owner Command Center & Dashboard

#### 🎯 Kya Hai? (What is this?)
Boutique ke daily operations ka central pulse screen.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Boutique owner ko subah dukaan kholte hi pata hona chahiye ki aaj kaunse suits deliver karne hain, kitna paisa collect hua, aur workshop me kitna kaam pending hai.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **KPI Metrics Grid**:
  - `Total Clients`: Boutique ka total registered customer base.
  - `Garment Styles`: Active stitching patterns (Sherwanis, Tuxedos, Kurtas, Blouses).
  - `Revenue & Cashflow`: Total advance + balance collections.
  - `Expenses`: Fabric purchase, thread, buttons, karigar advance, shop rent.
  - `Net Operating Margin`: Inflow minus Outflow calculation.
- **7-Day Urgent Delivery Alerts (`notifyOrder`)**:
  - Agle 7 dino me jin garments ki delivery deadline hai, unka alert counter aur table top par highlight hota hai.
- **Financial Cash Flow Chart**: Monthly revenue vs expense ka comparative graph.
- **Order Status Distribution Donut**: Kitne garments Cutting me hain, kitne Stitching me, aur kitne Trial ke liye ready hain.

#### 🚀 Business Fayda:
0% delivery delay aur owner ko har sham shop band karte waqt exact daily net profit pata chalta hai.

---

### 2. 👥 Customer Management & History (`/customer`)

#### 🎯 Kya Hai? (What is this?)
High-value clients ki digital profile directory jisme unki contact details, past orders, balance dues, aur measurement records store hote hain.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Customer jab 6 mahine baad dubara aata hai, toh unka purana measurement book me dhoondne me 20 minute lagte the.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Phone number ya Name se instant live search.
- Profile ke andar 1-click me show hota hai:
  - Total orders placed & Total lifetime spent.
  - Unpaid balance invoices.
  - Attached body measurement records with timestamps.
  - Special fit preferences (e.g. "Prefers loose waist, slim sleeves, right shoulder low").

#### 🚀 Business Fayda:
Customer retention 2x badhta hai kyunki client ko har baar dobara napwayi (measurement) dene ki zaroorat nahi padti.

---

### 3. 📐 3D Body Measurement Passports (`/measurement`)

#### 🎯 Kya Hai? (What is this?)
World-class anatomical measurement engine jo har garment category ke standard aur custom body measurements store karta hai.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Galat measurement ki wajah se kapda kharab hona tailoring business ka sabse bada loss hota hai.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **Category Wise Structured Fields**:
  - **Men's Suiting**: Chest, Waist, Hip, Shoulder, Sleeve Length, Bicep, Wrist, Jacket Length, Neck, Front Cross, Back Cross.
  - **Trousers**: Length, Inseam, Waist, Hip, Thigh, Knee, Bottom Hem, Rise, Fork.
  - **Ethnic / Sherwani / Kurta**: Collar, Chest, Waist, Flare, Slit Length, Shoulder Slope.
  - **Women's Ethnic (Blouse/Lehenga)**: Bust, Upper Chest, Under Bust, Apex to Apex, Blouse Length, Armhole, Front Deep Neck, Back Deep Neck.
- **Visual Posture & Fitting Notes**: Master tailor posture notes add kar sakta hai (e.g. Erect Posture, Stooping Back, Sloping Shoulders).
- **Printable Measurement Sheet**: 1-click me workshop print ya PDF generation.

#### 🚀 Business Fayda:
Fitting accuracy 99.8% ho jati hai aur alteration costs 90% kam ho jate hain.

---

### 4. 📝 3-Step Bespoke Order Booking (`/order/create`)

#### 🎯 Kya Hai? (What is this?)
Ek seamless multi-step order intake workflow jo counter par customer ke samne 2 minute me order book karta hai.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Bespoke tailoring me bohot saari details hoti hain — style, fabric code, trial date, delivery date, advance payment, karigar assignment. Sab kuch structured record hona chahiye.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
1. **Step 1 - Client Selection**: Existing customer search karo ya naya customer add karo.
2. **Step 2 - Garment & Style Configuration**:
   - Garment choose karo (e.g. 2-Piece Suit, Sherwani).
   - Saved measurement select karo ya naya measurement link karo.
   - Styling notes & design reference images upload karo.
   - **Trial Date** aur **Final Delivery Date** set karo.
3. **Step 3 - Pricing, Fabric & Advance Payment**:
   - Stitching rate + Material cost add karo.
   - Advance amount receive karo (Cash / UPI / Card).
   - Auto-calculate balance amount.
   - Order submit hote hi **Customer ko WhatsApp/SMS invoice link** chala jata hai aur workshop me **Print Job Card** generate ho jata hai.

#### 🚀 Business Fayda:
Counter processing fast hoti hai aur advance payment lene me kabhi galti nahi hoti.

---

### 5. 🧾 Quick POS Counter Billing & Invoices (`/pos`, `/invoice`)

#### 🎯 Kya Hai? (What is this?)
Fast-paced retail counter billing screen jisme ready-made garments, accessories, alterations, aur bespoke orders ka instant bill banta hai.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Counter par line na lage aur customer ko GST-compliant professional receipt mile.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Barcode scanner ya quick product selector se items add hote hain.
- Split payments support (e.g. ₹2000 Cash + ₹3000 UPI).
- Thermal printer (80mm / 58mm) receipt aur standard A4/A5 PDF invoices print hote hain.
- Unique QR-Code print hota hai jise scan karke customer live tracking page dekh sakta hai.

#### 🚀 Business Fayda:
Professional branding, 100% tax compliance, aur cash drawer ka daily accurate closing balance.

---

### 6. 🎛️ Production Kanban & Garment Pipeline (`/production/kanban`)

#### 🎯 Kya Hai? (What is this?)
Workshop floor par chal rahe sabhi kapdon ka visual drag-and-drop workflow board.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Kapde workshop me kahan fase hain (Cutting table par ya Karigar ke paas ya Finishing par), yeh janne ke liye shop floor par chillana na pade.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **Standard Lifecycle Columns**:
  1. 🟡 `Pending Fabric` (Kapda aana baaki hai)
  2. 🔵 `Pattern Cutting` (Master Ji cutting kar rahe hain)
  3. 🟣 `Hand Stitching` (Silayi chal rahi hai)
  4. 🟠 `Trial & Fitting` (Customer trial ke liye ready)
  5. 🟢 `Final Finishing & Press` (Steam iron & Packaging)
  6. ✅ `Ready For Delivery` (Store me rack par placed)
- Owner ya staff card ko drag karke agle stage me drop kar dete hain.

#### 🚀 Business Fayda:
Workload bottlenecks turant solve hote hain aur koi bhi order miss nahi hota.

---

### 7. 👷 Worker Assignments & Karigar Management (`/staff`, `/workers/assignments`)

#### 🎯 Kya Hai? (What is this?)
Boutique ke tailors, cutters, finishing staff aur helpers ko task allocate karne aur unki efficiency monitor karne ka tool.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Kis karigar ke paas kitna load hai aur kisne time par suit complete kiya, iska transparent record rakhna.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Order booking ke time ya Kanban board se kisi bhi garment ko specific tailor ko assign kiya jata hai.
- System automatic check karta hai ki tailor par pehle se kitne pieces pending hain taaki work overload na ho.
- Worker ke mobile login par direct unka assignment update ho jata hai.

#### 🚀 Business Fayda:
Equal work distribution aur accurate accountability.

---

### 8. 💰 Tailor Piece-Rate Wages & Karigar Ledgers (`/tailor-ledger`)

#### 🎯 Kya Hai? (What is this?)
Tailors ke piece-rate payments, daily kharcha/advances, aur weekly settlement ka automated ledger book.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Weekend par karigaron ke hisab me ladayi hoti thi ki kisne kitne kurtas/pants siye aur kitna advance liya tha.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Har cloth type ka piece-rate stitching charge define hota hai (e.g. Pant Stitching = ₹400, Suit = ₹1500).
- Jaise hi tailor garment complete karta hai, credit unke ledger me auto-add ho jata hai.
- Jab tailor Beech hafte me advance cash (kharcha) leta hai, owner ledger me debit entry pass karta hai.
- Weekend par 1-click me **Net Wage Summary Statement** print/settle ho jata hai.

#### 🚀 Business Fayda:
100% peaceful relationship with karigars, zero calculation errors.

---

### 9. 🧵 Raw Materials, Fabrics & Trims Inventory (`/materials`, `/inventory`)

#### 🎯 Kya Hai? (What is this?)
Fabric rolls, designer buttons, zippers, buckram (canvassing), linings, aur threads ka stock management module.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Aisa na ho ki order book ho jaye aur baad me pata chale ki matching lining ya button khatam ho gaye hain.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Material purchase entry (Supplier Name, Cost per Meter/Unit, Available Quantity).
- Order creation ke waqt material deduct ho jata hai (e.g. 1 Suit = 3.25 meters fabric deducted).
- **Low Stock Alerts**: Jab fabric ya lining threshold se niche jata hai, system red badge warning deta hai.

#### 🚀 Business Fayda:
Fabric theft aur unexpected stockouts khatam ho jate hain.

---

### 10. 📈 Financial Reports, Cash Register & P&L (`/financials`, `/reconciliation`)

#### 🎯 Kya Hai? (What is this?)
Boutique ki overall financial health, Profit & Loss analysis, aur daily cash counter reconciliation.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Boutique owner ko revenue toh dikhta hai par mahine ke aakhri me pata nahi chalta ki actual profit bacha kitna.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- **Real-Time P&L**: Total Invoiced Stitching Revenue minus (Fabric Costs + Tailor Wages + Operational Expenses + Rent).
- **Cash Drawer Reconciliation**: Cash in Hand at morning vs Cash collected vs Cash paid out for supplies = Exact physical cash matching.

#### 🚀 Business Fayda:
Solid financial control aur accurate business growth metrics.

---

### 11. 💬 Automated WhatsApp, SMS & Email Alerts (`/communication`)

#### 🎯 Kya Hai? (What is this?)
Automated customer communication gateway jo order ke har stage par client ko updates bhejta hai.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Customer ko update rehne se phone calls 80% kam ho jati hain.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Automatic triggers:
  - 🔔 *Order Booked*: "Namaste Mr. Verma, your 3-Piece Tuxedo order #ORD-104 is booked. Trial Date: 22nd Aug."
  - 🔔 *Trial Ready*: "Your garment is ready for trial fitting. Please visit Savile & Row Atelier."
  - 🔔 *Ready for Pick-Up*: "Your garment is packaged and ready for delivery."
  - 🔔 *Payment Receipt*: "Thank you for payment of ₹5,000. Balance: ₹0."

#### 🚀 Business Fayda:
Ultra-luxury VIP customer experience jo boutique ko standard tailors se 10x aage rakhta hai.

---

### 12. 🏢 Multi-Branch & Store Management (`/branch`)

#### 🎯 Kya Hai? (What is this?)
Agar boutique ke multiple outlets/studios hain (e.g. South Extension Branch & Bandra Studio), unhe single account se manage karna.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Owner ko har branch ki alag-alag performance, orders aur inventory monitor karni hoti hai.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Top bar se branch switch hoti hai.
- Har branch ka apna staff, orders aur cash counter separate rehta hai jabki master reports owner ko consolidated milti hain.

#### 🚀 Business Fayda:
Business expansion without software headaches.

---

### 13. 🛡️ Custom Staff Roles & Granular Permissions (`/role`)

#### 🎯 Kya Hai? (What is this?)
Store Manager, Cashier, Master Cutter, Sales Executive ke liye customized login permissions set karna.

#### 💡 Kyun Zaroori Hai? (Why this feature?)
Tailor ko financial P&L nahi dikhna chahiye, aur cashier ko master configuration edit nahi karni chahiye.

#### ⚙️ Kaise Kaam Karta Hai? (How it works?)
- Checkbox permission matrix se permissions grant/revoke hoti hain (e.g. `create order`, `view price`, `manage inventory`, `delete records`).

#### 🚀 Business Fayda:
100% data security aur staff fraud prevention.
