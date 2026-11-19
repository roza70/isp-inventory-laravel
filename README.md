# 🌐 ISP Inventory Management System

### 🏢 Developed for Square Informatix Limited

A web-based **ISP Inventory Management System** designed to streamline inventory operations, track individual networking devices, manage stock movements, and maintain accurate inventory records for **Square Informatix Limited**.

---

## 📌 Project Overview

The ISP Inventory Management System is designed to help manage networking equipment and inventory operations efficiently.

The system provides centralized management of products, devices, warehouses, organizations, stock receiving, device assignments, transfers, faulty equipment, stock adjustments, and wastage records.

Each physical device can be tracked individually using its **Serial Number and/or MAC Address**, helping maintain accurate inventory records and improve accountability.

## ✨ Key Features

### 📦 Inventory & Device Management
- Manage networking products and device information.
- Register individual devices using Serial Number and/or MAC Address.
- Track device conditions: New and Old.
- Monitor device statuses: In Stock, In Use, Faulty, Written Off, and Wasted.
- View available stock quantities automatically.

### 🏢 Organization Management
- Manage branch and organization information.
- Maintain organization contact details.
- Track devices assigned to different organizations.

### 🏬 Warehouse Management
- Manage multiple warehouses.
- Track the current warehouse location of devices.
- Maintain warehouse transfer records.

### 📥 Stock Receiving
- Record newly received networking devices.
- Maintain stock receiving history.
- Automatically update device inventory.

### 🔄 Device Usage & Return
- Assign devices to organizations.
- Record device issue dates and return dates.
- Track active and returned device assignments.
- Update inventory status when devices are returned.

### 🔧 Faulty Device Management
- Register faulty devices.
- Track fault descriptions and dates.
- Manage repair and resolution records.
- Return repaired devices to inventory.

### 🚚 Warehouse Transfer
- Request transfers between warehouses.
- Maintain transfer history.
- Support Admin approval and rejection workflows.

### 📊 Stock Adjustment
- Submit stock increase and decrease requests.
- Support Admin approval and rejection.
- Maintain adjustment history and approval remarks.

### 🗑️ Device Wastage Management
- Record damaged or unusable devices.
- Maintain wastage dates, reasons, and remarks.
- Update device inventory status accordingly.

### 🔐 Authentication & Authorization
- Secure user authentication.
- Admin and Staff roles.
- Role-based access control.
- Protected administrative operations.

### 📈 Dashboard
- Total device count.
- In-stock, in-use, and faulty device summaries.
- New and old device summaries.
- Product-wise available stock quantities.

---

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| PHP 8.2 | Backend Programming |
| Laravel 12 | Backend Framework |
| MySQL / MariaDB | Database Management |
| Blade | Server-side Templating |
| HTML5 | Web Structure |
| CSS3 | Styling |
| JavaScript | Client-side Interactions |
| Laravel Breeze | Authentication |
| Git & GitHub | Version Control |

---

## ⚙️ Installation & Setup

Follow these steps to run the project locally.

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/roza70/isp-inventory-laravel.git
```

### 2️⃣ Navigate to the Project Directory

```bash
cd isp-inventory-laravel
```

### 3️⃣ Install PHP Dependencies

```bash
composer install
```

### 4️⃣ Create Environment Configuration

```bash
cp .env.example .env
```

Configure your database credentials in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=isp_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Generate Application Key

```bash
php artisan key:generate
```

### 6️⃣ Run Database Migrations

```bash
php artisan migrate
```

### 7️⃣ Start the Development Server

```bash
php artisan serve
```

Open your browser and visit:

**http://127.0.0.1:8000**

---

## 📂 Project Modules

The application includes the following major modules:

- Dashboard
- Products
- Organizations
- Warehouses
- Devices
- Stock Receiving
- Usage Information
- Router Transactions
- Faulty Device Management
- Warehouse Transfers
- Stock Adjustments
- Wastage Management
- User Authentication & Authorization

---

## 🎯 Project Objectives

- Digitize ISP equipment inventory operations.
- Ensure individual device-level tracking.
- Improve stock accuracy and accountability.
- Simplify device assignment and return management.
- Maintain warehouse movement and transaction history.
- Improve inventory monitoring and administrative control.
- Reduce manual inventory record-keeping.

---

## 👨‍💻 Development

**Project:** ISP Inventory Management System  
**Organization:** Square Informatix Limited  
**Framework:** Laravel 12  
**Backend Language:** PHP  
**Database:** MySQL / MariaDB  
**Repository:** [GitHub Repository](https://github.com/roza70/isp-inventory-laravel)

---

## 🏢 Organization

**Square Informatix Limited**

Developed as an inventory management solution to support networking equipment and ISP inventory operations.

---

<p align="center">
  <b>🚀 Built with Laravel | Designed for Efficient Inventory Management</b>
</p>
