# 📦 Meksiko Inc. - Inventory & Invoice System

> A streamlined fullstack web application designed to track products, manage stock levels, and generate invoices efficiently. Built with a robust backend architecture and a clean, modern user interface.

**💡 Disclaimer & Project History:** *This repository is an enhanced iteration of my original Final Project for the BNCC (Bina Nusantara Computer Club) Back End Development Bootcamp. I recently revisited this codebase to address the shortcomings of my initial submission. I completely refactored the core backend logic (including implementing proper transaction state management) and upgraded the UI from basic Bootstrap to a polished Tailwind CSS design. This project serves as a showcase of my continuous learning and growth as a software engineer.*

---

## 📌 Project Case Study

As a software developer at **PT Meksiko**, I was tasked by the CEO to build a comprehensive **Product Data Management Website**. The system strictly separates privileges between Administrators and regular Users.

### System Requirements & Logic
- **Role-Based Access Control (RBAC):**  
  - **Admin:** Exclusive access to inventory management. Registered manually via database seeding for security.
  - **User:** Access to the storefront and invoice generation. Registered via the web interface.
  - *Middleware ensures unauthorized users attempting to access Admin routes are safely redirected.*

- **Inventory Management (Admin):**  
  - Full CRUD operations for Products and Categories.
  - **Relational Data:** 1 Category ↔ Many Products (One-to-Many).
  - Secure local file handling for product image uploads.
  - Strict data validation (e.g., Price formatting, minimum/maximum string lengths).

- **Transaction & Invoice System (User):**  
  - **Shopping Cart Logic:** Implementation of Draft/Completed state management. Items are accumulated in a single active session before checkout.
  - **Sequential Numbering:** Enterprise-standard auto-generated invoice IDs (e.g., `INV-YYYYMMDD-0001`) preventing database collisions.
  - **Dynamic Calculation:** Real-time subtotal and total price computation.
  - **Stock Validation:** Real-time stock checking. Prevents users from adding out-of-stock items or exceeding available inventory quantities.

---

## 🛠 Tech Stack

- **Backend Logic:** Laravel (PHP)
- **Database:** MySQL (Eloquent ORM)
- **Frontend UI/UX:** Blade Templates, Tailwind CSS
- **Styling Concept:** Minimalist, clean design language prioritizing whitespace and intuitive user feedback.
- **Authentication:** Laravel Auth (Session-based)

---

## 🔑 Features & Previews

### 🔐 Authentication
Secure and clean entry points for users, featuring real-time validation error handling.
- **Register**  
  ![Register](screenshots/Register.png)  
- **Login**  
  ![Login](screenshots/Login.png)  

### 👨‍💼 Admin Dashboard (Inventory Control)
A clean management interface allowing admins to seamlessly organize categories and update product stock.
- **Product Management**  
  ![Product](screenshots/Product.png)  
- **Add/Edit Product Interface**  
  ![Add Product](screenshots/AddProduct.png)  
- **Category Management**  
  ![Category](screenshots/Category.png)  

### 👤 User Storefront & Invoicing
A frictionless checkout experience. Users can browse the catalog, add items to their active invoice, and finalize shipping details.
- **Product Catalog**  
  ![Catalog](screenshots/Catalog.png)
- **Active Invoice / Cart**  
  ![Invoice Details](screenshots/AddInvoice.png)  
- **Invoice History (State: Completed)**  
  ![My Invoices](screenshots/MyInvoice.png)  

---

## 🎥 Video Demonstration

To see the state management, stock validation, and the Tailwind CSS responsive UI in action, please watch the full project demo:

👉 **[Watch the Demo Video Here](https://drive.google.com/file/d/1D6iYUyKTtPdeegFgdwDEKAcRjC8Bq4kz/view?usp=drive_link)**

---

## 🙏 Acknowledgment

This project was originally developed as the capstone requirement for the **BNCC Bootcamp - Calon Praetorian 2025**. The current version reflects significant self-driven improvements to meet higher industry standards.
