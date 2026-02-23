# 🛒 Ecommerce App — OAuth2 SSO Server

The **Ecommerce App** acts as the central authentication server in a Single Sign-On (SSO) system built with OAuth2 (Laravel Passport). When a user logs in here, they can access the Foodpanda App automatically without re-entering credentials.

---

## 🔗 Live Demo

- **URL:** `https://your-ecommerce-url.com`
- **Email:** `hmojammel29@gmail.com`
- **Password:** `admin`

---

## ⚙️ Tech Stack

| Layer       | Technology              |
|-------------|-------------------------|
| Framework   | Laravel 12              |
| Auth        | Laravel Passport (OAuth2)|
| Database    | MySQL                   |
| Frontend    | Blade + Pure CSS (Inter font) |
| SSO Protocol| OAuth 2.0 Authorization Code Grant |

---

## 🚀 Local Setup Instructions

### 1. Clone the repository
```bash
git clone https://github.com/YOUR_USERNAME/zavisoft-tasks.git
cd zavisoft-tasks/ecommerce-app
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
APP_NAME="Ecommerce App"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zavi_ecommerce
DB_USERNAME=root
DB_PASSWORD=

FOODPANDA_URL=http://127.0.0.1:8001
```

### 5. Create database

Create a MySQL database named `ecommerce_db`.

### 6. Run migrations and seeders
```bash
php artisan migrate
php artisan passport:install
php artisan db:seed
```

### 7. Register Foodpanda as OAuth client
```bash
php artisan passport:client --name="Foodpanda App" --redirect_uri="http://127.0.0.1:8001/auth/callback"
```

> Save the **Client ID** and **Client Secret** — paste them into foodpanda-app `.env`

### 8. Start the server
```bash
php artisan serve
```

Visit: `http://127.0.0.1:8000`

---

## 🔐 How SSO Works
```
┌─────────────────────────────────────────────────────────┐
│                     SSO FLOW                            │
│                                                         │
│  1. User logs in to Ecommerce App                       │
│  2. User clicks "Open Foodpanda" on dashboard           │
│  3. Browser redirects to Foodpanda with OAuth request   │
│  4. Foodpanda redirects to Ecommerce /oauth/authorize   │
│  5. Ecommerce shows Authorization screen                │
│  6. User clicks "Authorize"                             │
│  7. Ecommerce issues authorization code                 │
│  8. Foodpanda exchanges code for access token           │
│  9. Foodpanda calls /api/user with the token            │
│ 10. Ecommerce returns user profile                      │
│ 11. Foodpanda logs user in automatically                │
└─────────────────────────────────────────────────────────┘
```

### Protocol: OAuth 2.0 Authorization Code Grant

| Component | Role |
|---|---|
| Ecommerce App | Authorization Server (issues tokens) |
| Foodpanda App | Client Application (consumes tokens) |
| Laravel Passport | OAuth2 server implementation |
| `/oauth/authorize` | Authorization endpoint |
| `/oauth/token` | Token exchange endpoint |
| `/api/user` | Resource endpoint (protected) |

### Why OAuth2?

OAuth2 Authorization Code Grant is the industry standard for SSO between independent applications. Unlike session sharing (which tightly couples apps) or simple JWT sharing (which lacks revocation), OAuth2 keeps both applications truly independent while sharing identity securely.

---

## 📁 Project Structure
```
ecommerce-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/LoginController.php     # Login, logout, SSO token generation
│   │   ├── Api/UserController.php       # /api/user endpoint for Foodpanda
│   │   └── DashboardController.php      # Dashboard with SSO launch
│   └── Models/
│       └── User.php                     # HasApiTokens trait for Passport
├── config/
│   └── auth.php                         # api guard → passport driver
├── routes/
│   ├── web.php                          # Web routes + Passport::routes()
│   └── api.php                          # Protected /api/user route
└── resources/views/
    ├── auth/login.blade.php             # Split-panel login UI
    ├── dashboard.blade.php              # SSO launch dashboard
    └── vendor/passport/authorize.blade.php  # OAuth authorization screen
```

---

## 🔑 Demo Credentials
```
Email:    hmojammel29@gmail.com
Password: admin
```

---

## 📝 Notes

- Passport tokens expire in **10 days**
- Refresh tokens expire in **15 days**
- Token revocation happens on logout (all tokens deleted)
- The `/api/user` endpoint is protected by `auth:api` middleware
