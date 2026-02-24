# 🎓 E-Rapot System - Digital Assessment Platform

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

A web-based application designed to manage student assessments, generate PDF report cards automatically, and ensure document authenticity using **QR Code Validation**. Developed as a **personal portfolio project** to demonstrate proficiency in Full-Stack Web Development and System Integration.
---

## 📺 Demo Video

Watch the full demonstration of the system here:

[![Watch the Demo](https://img.youtube.com/vi/G1zfvbQ4Gc8/maxresdefault.jpg)](https://www.youtube.com/watch?v=G1zfvbQ4Gc8)
> *Click the image above to watch the video on YouTube.*

---

## ✨ Key Features

* **📊 Dashboard & Analytics**: Visual summary of student grades (Lulus/Remidi) with charts.
* **📝 CRUD Assessment**: Professors can easily input, edit, and delete student scores.
* **📄 Auto-Generate PDF**: One-click download for official student report cards.
* **✅ QR Code Validation**: Scannable QR Code on the PDF that leads to an online validation page (showing Logo ITS & Department).
* **🔒 Secure Authentication**: Login system for lecturers/admins.

---

## 🛠️ Tech Stack

* **Framework:** Laravel 11
* **Language:** PHP 8.2+
* **Database:** MySQL
* **Frontend:** Blade Templates + Bootstrap 5
* **PDF Engine:** Barryvdh/DomPDF
* **Tunneling:** Ngrok (for public QR scanning)

---

## 🚀 How to Run Locally

1.  **Clone the Repository**
    ```bash
    git clone [https://github.com/cndrdwynt/eraport-sidang.git](https://github.com/cndrdwynt/eraport-sidang.git)
    cd eraport-sidang
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    * Copy `.env.example` to `.env`
    * Configure your database credentials (DB_DATABASE, etc.)
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Run Migrations**
    ```bash
    php artisan migrate --seed
    ```

5.  **Start the Server**
    ```bash
    php artisan serve
    ```

---

## 👤 Author

**Candra Dwi**
* **Institution:** Institut Teknologi Sepuluh Nopember (ITS)
* **Major:** Computer Engineering
* **GitHub:** [@cndrdwynt](https://github.com/cndrdwynt)

---

Powered by **Laravel** & **Passion**. Developed by **Candra Dwi**.
