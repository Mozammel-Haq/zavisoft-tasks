# ZaviSoft Laravel Developer Assessment

**Candidate:** Mozammel Haq
**Submission Date:** 25 February 2026
**Email:** hmojammel29@gmail.com

---

## 📦 Repository Structure

The repository contains three independent Laravel 12 applications demonstrating SSO and Inventory Management capabilities.

```bash
zavisoft-tasks/
├── ecommerce-app/     # Task 1: OAuth2 Authorization Server (SSO Provider)
├── foodpanda-app/     # Task 1: OAuth2 Client Application (SSO Consumer)
└── inventory-app/     # Task 2: Inventory System with Double-Entry Accounting
```

---

## 🔗 Local Access Points

| App | Local URL | Demo Email | Password |
|-----|-----|-------|----------|
| **Ecommerce** (SSO Server) | [http://127.0.0.1:8000](http://127.0.0.1:8000) | `hmojammel29@gmail.com` | `admin` |
| **Foodpanda** (SSO Client) | [http://127.0.0.1:8001](http://127.0.0.1:8001) | *Login via Ecommerce SSO* | — |
| **Inventory** (Standalone)  | [http://127.0.0.1:8002](http://127.0.0.1:8002) | `hmojammel29@gmail.com` | `admin` |

---

## Task 1 — Multi Login SSO System

Two independent Laravel applications connected via **OAuth2 Authorization Code Grant**.

- Login to Ecommerce → click "Open Foodpanda" → auto logged into Foodpanda
- No credentials re-entry required
- Full setup: see [`ecommerce-app/README.md`](./ecommerce-app/README.md)
- Full setup: see [`foodpanda-app/README.md`](./foodpanda-app/README.md)

## Task 2 — Inventory Management System

Simplified inventory system with double-entry accounting.

- Products, sales, automatic journal entries, financial report
- Full setup: see [`inventory-app/README.md`](./inventory-app/README.md)

---

## 🛠️ Quick Start (All Apps)
```bash
git clone https://github.com/Mozammel-Haq/zavisoft-tasks.git

# Terminal 1
cd ecommerce-app && composer install && php artisan migrate --seed && php artisan serve

# Terminal 2
cd foodpanda-app && composer install && php artisan migrate && php artisan serve --port=8001

# Terminal 3
cd inventory-app && composer install && php artisan migrate --seed && php artisan serve --port=8002
```