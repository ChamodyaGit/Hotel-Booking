🏨 Hotel Booking & Management System
A professional Hotel Booking & Management System built with Laravel 11, Tailwind CSS, and MySQL.  
This system includes:
🛏️ Room Inventory Management
📅 Booking & Reservation Management
👥 User Role Management (Admin / Manager / Receptionist)
📊 Audit Trail & Activity Logging
🔐 Secure Authentication & Authorization
📱 Responsive User Interface
---
🛠️ Prerequisites
Before you begin, ensure you have the following installed on your machine:
PHP 8.2 or higher
Composer
Node.js & NPM
MySQL or MariaDB
XAMPP / WampServer (optional for local database setup)
---
🚀 Installation Guide
Follow the steps below to set up the project locally.
1️⃣ Clone the Repository
```bash
git clone https://github.com/ChamodyaGit/Hotel-Booking.git
cd Hotel-Booking
```
---
2️⃣ Install Dependencies
Install PHP and frontend dependencies.
Install Composer Dependencies
```bash
composer install
```
Install NPM Packages
```bash
npm install
```
---
3️⃣ Configure Environment File
Copy the example environment file and generate the application key.
```bash
cp .env.example .env
php artisan key:generate
```
---
4️⃣ Database Configuration
Create a new database in MySQL.
Example database name:
```text
hotel_db
```
Then update your `.env` file with the correct database credentials.
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_db
DB_USERNAME=root
DB_PASSWORD=
```
---
5️⃣ Run Database Migrations & Seeders
Create all database tables and insert default system data.
```bash
php artisan migrate --seed
```
---
🖥️ Running the Application
Start the Laravel development server using:
```bash
php artisan serve
```
Once the server starts, open the following URL in your browser:
```text
http://127.0.0.1:8000
```
---
🔐 Default Admin Login
Use the following credentials to log in as the administrator for the first time.
Email	Password
admin@gmail.com	123456789
> ⚠️ For security purposes, please change the default password after the first login.
---
📦 Tech Stack
Backend: Laravel 11
Frontend: Tailwind CSS
Database: MySQL
Authentication: Laravel Breeze / Custom Auth
Icons & UI: Blade Components + Tailwind
---

