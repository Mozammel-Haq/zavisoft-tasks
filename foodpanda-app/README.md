# 🍔 Foodpanda App — OAuth2 SSO Client

The **Foodpanda App** is an independent Laravel application that accepts Single Sign-On (SSO) login from the Ecommerce App using the OAuth2 Authorization Code Grant. Users logged into Ecommerce can access Foodpanda automatically — no password required.

---

## 🔗 Live Demo

- **URL:** `https://your-foodpanda-url.com`
- **SSO Demo:** Login to Ecommerce → click "Open Foodpanda"
- **Direct Login Email:** `hmojammel29@gmail.com`
- **Password:** `admin`

---

## ⚙️ Tech Stack

| Layer       | Technology                        |
|-------------|-----------------------------------|
| Framework   | Laravel 12                        |
| SSO Client  | Laravel HTTP Client (no Socialite)|
| Database    | MySQL                             |
| Frontend    | Blade + Pure CSS (Inter font)     |
| SSO Protocol| OAuth 2.0 Authorization Code Grant|

---

## 🚀 Local Setup Instructions

### Prerequisites

> ⚠️ Ecommerce App must be running first. Complete its setup before this.

### 1. Navigate to foodpanda-app
```bash
cd zavisoft-tasks/foodpanda-app
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
APP_NAME="Foodpanda App"
APP_URL=http://127.0.0.1:8001

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zavi_foodpanda
DB_USERNAME=root
DB_PASSWORD=

SSO_SERVER_URL=http://127.0.0.1:8000
SSO_CLIENT_ID=<client_id_from_ecommerce_setup>
SSO_CLIENT_SECRET=<client_secret_from_ecommerce_setup>
SSO_REDIRECT_URI=http://127.0.0.1:8001/auth/callback
```

### 5. Create database

Create a MySQL database named `zavi_foodpanda`.

### 6. Run migrations
```bash
php artisan migrate
```

### 7. Start the server
```bash
php artisan serve --port=8001
```

Visit: `http://127.0.0.1:8001`

---

## 🔐 SSO Flow — Foodpanda Side
```
User clicks "Login via Ecommerce SSO"
        │
        ▼
/auth/redirect  →  builds OAuth URL  →  redirects to Ecommerce /oauth/authorize
        │
        ▼ (after user approves on Ecommerce)
/auth/callback  →  receives authorization code
        │
        ▼
POST /oauth/token on Ecommerce  →  exchange code for access token
        │
        ▼
GET /api/user on Ecommerce (with token)  →  fetch user profile
        │
        ▼
firstOrCreate user in zavi_foodpanda  →  Auth::login()  →  Dashboard
```

### Key File: `SSOController.php`
```
redirect()   — Builds the OAuth authorization URL and redirects user
callback()   — Handles the code exchange, token fetch, user creation, login
```

### Security Measures

- **State parameter** — random 40-char string prevents CSRF attacks
- **Server-to-server token exchange** — authorization code never exposed to browser
- **Random password** — SSO users get a bcrypt random password (SSO only)
- **firstOrCreate by sso_id** — prevents duplicate accounts

---

## 📁 Project Structure
```
foodpanda-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/SSOController.php       # Core SSO redirect + callback
│   │   ├── Auth/LoginController.php     # Standard login fallback
│   │   └── DashboardController.php      # Post-login dashboard
│   └── Models/
│       └── User.php                     # Has sso_id field
├── config/
│   └── sso.php                          # SSO server URL, client credentials
├── routes/
│   └── web.php                          # /auth/redirect + /auth/callback
└── resources/views/
    ├── auth/login.blade.php             # Login with SSO button
    └── dashboard.blade.php              # Shows SSO source confirmation
```

---

## 📝 Notes

- Users created via SSO are stored locally in `zavi_foodpanda`
- Matched by `sso_id` (ecommerce user ID) to prevent duplicates
- Name and email sync on every SSO login
- Standard email/password login also works independently
