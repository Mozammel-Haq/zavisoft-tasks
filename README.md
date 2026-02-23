# ZaviSoft Laravel Developer Assessment

**Candidate:** Mozammel Haq
**Submission Date:** 25 February 2026
**Email:** hmojammel29@gmail.com

---

## 📦 Repository Structure
```
zavisoft-tasks/
├── ecommerce-app/     # Task 1 — OAuth2 SSO Server
├── foodpanda-app/     # Task 1 — OAuth2 SSO Client
└── inventory-app/     # Task 2 — Inventory Management System
```

---

## 🔗 Live Demos

| App | URL | Email | Password |
|-----|-----|-------|----------|
| Ecommerce | https://your-ecommerce-url.com | hmojammel29@gmail.com | admin |
| Foodpanda | https://your-foodpanda-url.com | SSO from Ecommerce | — |
| Inventory | https://your-inventory-url.com | admin@inventory.com | password |

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