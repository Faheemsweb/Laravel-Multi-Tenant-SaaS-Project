# 🏢 Laravel Multi-Tenant SaaS App (Laravel 12 + Spatie v4)

A modern, scalable SaaS starter kit using **Laravel 12**, **Spatie Multitenancy v4 (isolated DB mode)**, and a clean **environment-separated architecture**.

---

## 🚀 Project Overview

This project implements a **multi-tenant SaaS platform** with:

- Root onboarding flow
- Queued tenant provisioning
- Subdomain-based tenant isolation
- Admin-only landlord dashboard
- Fully scoped tenant environments with separate databases

Each tenant gets a **completely isolated database**, login system, and dashboard. The project is environment-aware and designed for production scalability.

---

## 🧱 Architecture Overview

| Environment     | Domain                     | Purpose                                 |
|-----------------|----------------------------|-----------------------------------------|
| **Root**        | `https://myapp.test`       | Public signup & onboarding              |
| **Landlord**    | `https://landlord.myapp.test` | Admin dashboard for platform ops       |
| **Tenant**      | `https://{tenant}.myapp.test` | Tenant-specific login, dashboard, data |

---

## 🛠️ Tech Stack

| Layer          | Technology                                       |
|----------------|--------------------------------------------------|
| Backend        | Laravel 12, PHP 8.2                              |
| Multitenancy   | Spatie Multitenancy v4 (Isolated DB Mode)        |
| Frontend       | HTML,CSS and Javascript                          |
| Styling        | Bootstrap   v5                                   |
| DB             | MySQL                                            |
| Queue          | Laravel Queues (Database)                        |
| Local Dev      | Custom Virtual Hosts                             |

---

## 📂 Folder Structure Highlights
├── app/
│ ├── Http/
│ │ └── Controllers/Root/OnboardingController.php
│ ├── Jobs/ProvisionTenant.php
│ ├── Models/OnboardingSession.php
│ └── Models/Tenant.php
├── routes/
│ ├── root.php
│ ├── landlord.php
│ └── tenant.php
├── database/
│ ├── migrations/landlord/
│ └── migrations/tenant/
├── resources/
│ ├── views/ (Blade)
│ └── js/ (Inertia + React)

---

## ✍️ Features

✅ Subdomain-based tenant resolution  
✅ 5-step onboarding (resume-capable)  
✅ E.164 phone input with country selector & flags  
✅ Laravel queues for provisioning  
✅ Isolated DB per tenant (Spatie v4)  
✅ Admin landlord dashboard  
✅ Secure, scoped tenant auth  
✅ Environment-separated routes & middleware  
✅ Production-ready structure

---

## 📝 Onboarding Flow Steps

1. **Account Info** – Full name, email (globally unique)
2. **Password Setup** – Secure password (min 8 chars, symbols, caps)
3. **Company Details** – Company name, unique subdomain, logo
4. **Billing Info** – Address, country, phone (E.164 with flag)
5. **Confirmation** – Triggers queued provisioning

Each step saves progressively in the **landlord DB**. Sessions are resumable.

---

## 📦 Tenant Provisioning Logic

Provisioning is handled via a **Laravel queued job** that:

- Creates a tenant record
- Dynamically creates a separate DB
- Runs migrations
- Seeds initial user from onboarding data
- Applies default config (locale, timezone, etc.)

Provisioning is **idempotent** and retry-safe.

---

## 📦 Local Development Setup
Follow these steps to get the application running on your local machine.

## 1. Clone the Repository
```html
git clone https://github.com/Faheemsweb/Laravel-Multi-Tenant-SaaS-App
cd Laravel-Multi-Tenant-SaaS-App
```
## 2. Install Dependencies
Install all the required PHP dependencies using Composer.
```html
composer install
```
## 3. Environment Configuration
Configure your local environment.

First, copy the example environment file and then generate your unique application key.
```html
cp .env.example .env
php artisan key:generate
```

Next, open the newly created .env file in a text editor and update the following variables to match your local setup:

APP_URL: The URL for your local development site (e.g., http://saas-app.test).

DB_DATABASE: The name of your main "landlord" database.

DB_USERNAME: Your database username.

DB_PASSWORD: Your database password.
## 4. Database Migration
Run the migrations to set up the necessary database tables. This includes the central "landlord" database and any default tenant migrations.
# Set up the central landlord tables
```html
php artisan migrate --database=landlord
```
## 5. Local Domain Setup
For the multi-tenancy to work correctly, you'll need to set up a local domain with wildcard subdomains.
Edit Your hosts File: Add an entry to point your chosen domain and a wildcard subdomain to your local machine.
```html
127.0.0.1   saas-app.test
127.0.0.1   *.saas-app.test
```
Configure Your Web Server: Set up a virtual host in your web server (Apache/Nginx) that points the domain (saas-app.test) and its wildcard subdomains (*.saas-app.test) to the project's /public directory.
## 6. Final Steps
Almost there! Run these final commands to link your storage and start the queue worker.
# Run the queue worker to process background jobs
```html
php artisan queue:work
```

Your application should now be running on the local domain you configured! ✅

## 🎬 Demo Video

[📽️ Click here to watch the full onboarding & provisioning demo](https://drive.google.com/drive/folders/1-0FRUs5r8JfNaRZ1aKuuk9mMt1MP78qX)

🙋 Author
Faheem Ali
---
Backend Developer (PHP / Laravel)
---
📧 contactfaheemali@gmail.com
---
📱 +92 302 1898326
