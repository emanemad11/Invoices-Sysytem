# 📄 Laravel Invoices Management System

A complete invoice management system built with Laravel.  
It provides a **dashboard for administrators** and an **interface for regular users** to manage invoices, attachments, customers, reports, and user roles.

---

## 🚀 Features

### ✅ Admin Dashboard
- Manage all invoices and archive
- View detailed invoice history
- Attach files to invoices
- Manage products and sections
- Generate customer & invoice reports
- Control users and roles (RBAC)
- View user profiles and settings

### 👤 Regular Users
- View and download their own invoices
- Upload attachments to their invoices
- Access invoice details and status
- Limited access based on their assigned role

---

## 🛠️ Tech Stack

- **Laravel** (PHP Framework)
- **Blade** Templating Engine
- **MySQL** Database
- Role & Permission system (e.g., Laravel Permission)
- Bootstrap for UI (if applicable)

---

## 📁 Folder Structure (Main Controllers)

```
app/Http/Controllers/
├── AdminController.php
├── CustomerReportController.php
├── HomeController.php
├── InvoiceArchieveController.php
├── InvoiceAttacchmentController.php
├── InvoiceController.php
├── InvoiceDetailController.php
├── InvoiceReportController.php
├── ProductController.php
├── ProfileController.php
├── RoleController.php
├── SectionController.php
└── UserController.php
```

---

## ⚙️ Installation

1. Clone the repository:

```bash
git clone https://github.com/your-username/invoices-system.git
cd invoices-system
```

2. Install dependencies:

```bash
composer install
```

3. Create `.env` file and generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database settings in `.env` and run migrations:

```bash
php artisan migrate --seed
```

5. Serve the app:

```bash
php artisan serve
```

Then visit: `http://localhost:8000`

---

## 🔐 Authentication & Authorization

- Login system for admins and users
- Role-based access control (admin vs. user)
- Admin can assign roles and manage permissions

---

## 📝 License

This project is open-source and available under the [MIT license](LICENSE).

---

## 🙌 Author

Developed by [Eman Emad](https://github.com/emanemad-dev)
