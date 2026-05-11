# 🏨 Hotel Booking & Management System

A professional Hotel Management System built with **Laravel 11**, **Tailwind CSS**, and **MySQL**. This system includes room inventory, booking management, user roles (Admin/Manager/Receptionist), and a full Audit Trail.

---

## 🛠️ Prerequisites

Before you begin, ensure you have the following installed:
* **PHP 8.2** or higher
* **Composer**
* **Node.js & NPM** (for frontend assets)
* **MySQL** or **MariaDB**
* **XAMPP/WampServer** (optional, for local DB)

---

## 🚀 Installation Steps

Follow these steps to get the project running locally:

### 1. Clone the Project
```bash
git clone https://github.com/ChamodyaGit/Hotel-Booking.git
cd hotel-booking

2. Install Dependencies
Install PHP dependencies via Composer and Frontend packages via NPM:

composer install
npm install

3. Environment Configuration
Copy the example environment file and generate a unique application key:

cp .env.example .env
php artisan key:generate

4. Database Setup
Create a new database in your MySQL (e.g., hotel_db).

Open your .env file and update the database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_db
DB_USERNAME=root
DB_PASSWORD=

5. Run Migrations & Seeders
Create the table structure and populate initial data

php artisan migrate --seed

🖥️ Running the Application
Once the setup is complete, start the local development server:

php artisan serve

## 🔐 Default Credentials

You can use the following credentials to log in as an Administrator for the first time:

* **Email:** `admin@gmail.com`
* **Password:** `123456789`

> **Note:** For security reasons, please ensure you change the password or create a new admin account via the Profile Settings once you log in.
