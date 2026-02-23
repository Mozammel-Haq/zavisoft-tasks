# 📦 Inventory Management System

A simplified Inventory Management System with **double-entry accounting journal entries** and a **date-wise financial report**. Built as part of the ZaviSoft Laravel Developer Assessment.

---

## 🔗 Live Demo

- **URL:** `https://your-inventory-url.com`
- **Email:** `hmojammel29@gmail.com`
- **Password:** `admin`

---

## ⚙️ Tech Stack

| Layer        | Technology                     |
|--------------|--------------------------------|
| Framework    | Laravel 12                     |
| Database     | MySQL                          |
| Frontend     | Blade + Pure CSS (Inter font)  |
| Architecture | Service Layer Pattern          |
| Accounting   | Double-Entry Bookkeeping       |

---

## 🚀 Local Setup Instructions

### 1. Navigate to inventory-app
```bash
cd zavisoft-tasks/inventory-app
```

### 2. Install dependencies
```bash
composer install
```

### 3. Copy environment file
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env`
```env
APP_NAME="Inventory App"
APP_URL=http://127.0.0.1:8002

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zavi_inventory
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Create database

Create a MySQL database named `zavi_inventory`.

### 6. Run migrations and seeders
```bash
php artisan migrate
php artisan db:seed
```

> The seeder creates the demo product from the task brief:
> **Purchase: 100 TK | Sell: 200 TK | Stock: 50 units**

### 7. Start the server
```bash
php artisan serve --port=8002
```

Visit: `http://127.0.0.1:8002`

---

## 🔑 Demo Credentials
```
Email:    hmojammel29@gmail.com
Password: admin
```

---

## 📊 Accounting Logic

### Task Brief Scenario

| Field          | Value       |
|----------------|-------------|
| Purchase Price | 100 TK      |
| Sell Price     | 200 TK      |
| Opening Stock  | 50 units    |
| Qty Sold       | 10 units    |
| Discount       | 50 TK       |
| VAT Rate       | 5%          |
| Customer Paid  | 1,000 TK    |

### Calculation Breakdown
```
Gross Amount      = 10 × 200           = 2,000.00 TK
Discount          =                       (50.00) TK
Net before VAT    = 2,000 − 50         = 1,950.00 TK
VAT (5%)          = 1,950 × 5%         =    97.50 TK
Net Payable       = 1,950 + 97.50      = 2,047.50 TK
Amount Paid       =                     1,000.00 TK
Amount Due        = 2,047.50 − 1,000   = 1,047.50 TK
COGS              = 10 × 100           = 1,000.00 TK
```

### Journal Entry (Double-Entry)

| Account              | Type      | Debit (TK) | Credit (TK) |
|----------------------|-----------|-----------|-------------|
| Cash / Bank          | Asset     | 1,000.00  | —           |
| Accounts Receivable  | Asset     | 1,047.50  | —           |
| Sales Discount       | Expense   | 50.00     | —           |
| Sales Revenue        | Income    | —         | 2,000.00    |
| VAT Payable          | Liability | —         | 97.50       |
| Cost of Goods Sold   | Expense   | 1,000.00  | —           |
| Inventory            | Asset     | —         | 1,000.00    |
| **TOTAL**            |           | **3,097.50** | **3,097.50** |

✅ **Balanced — Total Debit = Total Credit**

---

## 🏗️ Architecture

### Service Layer Pattern

Business logic is separated from controllers into dedicated service classes:
```
SaleController  →  SaleService  →  JournalService
     (HTTP)         (Business)       (Accounting)
```

**`SaleService`** — handles:
- Stock validation with `lockForUpdate()` (prevents race conditions)
- All financial calculations
- Wrapped in `DB::transaction()` for atomicity

**`JournalService`** — handles:
- Automatic double-entry journal generation
- Every entry guaranteed balanced (DR = CR)

### Database Schema
```
products          — product catalog with pricing and stock
sales             — sale transactions with all financial fields
sale_items        — line items per sale
journal_entries   — accounting entry header
journal_lines     — individual debit/credit lines
```

---

## 📁 Project Structure
```
inventory-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/LoginController.php     # Authentication
│   │   ├── DashboardController.php      # Stats overview
│   │   ├── ProductController.php        # Product CRUD
│   │   ├── SaleController.php           # Sale recording
│   │   ├── JournalController.php        # Journal viewer
│   │   └── ReportController.php        # Financial report
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Sale.php
│   │   ├── SaleItem.php
│   │   ├── JournalEntry.php
│   │   └── JournalLine.php
│   └── Services/
│       ├── SaleService.php              # Sale processing + stock
│       └── JournalService.php           # Double-entry accounting
├── database/
│   ├── migrations/                      # 5 table migrations
│   └── seeders/
│       ├── UserSeeder.php               # Admin user
│       └── ProductSeeder.php            # Demo product (task brief)
└── resources/views/
    ├── dashboard.blade.php
    ├── products/ (index, create, edit, show)
    ├── sales/ (index, create, show)
    ├── journal/ (index, show)
    └── reports/financial.blade.php
```

---

## 📈 Features

- **Product Management** — add products with purchase price, sell price, opening stock
- **Grid / List View Toggle** — switch between table and card view for products
- **Sale Recording** — live calculation preview as you type
- **Auto Journal** — double-entry journal generated automatically on every sale
- **Financial Report** — date-wise breakdown with from/to filter
- **Stock Tracking** — current stock decrements automatically per sale
- **Low Stock Alert** — visual indicator when stock ≤ 5 units

---

## 📝 Notes

- All financial calculations use PHP's `round()` to 2 decimal places
- `DB::transaction()` ensures atomicity — if journal fails, sale rolls back
- `lockForUpdate()` on product prevents race conditions in concurrent sales
