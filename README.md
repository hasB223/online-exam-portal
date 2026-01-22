---

# Online Exam Portal

A role-based online examination system built with **Laravel 11 + Breeze**, designed for administrators, lecturers, and students to manage exams, conduct assessments, and review results efficiently.

The system focuses on clear workflows, access control, and usability, with support for **timed exams**, **auto-scoring**, **manual grading**, **bilingual UI**, and **dark/light mode**.

---

## ✨ Key Features

### Roles & Access

* **Admin**

  * Manage users, roles, classes, and subjects
  * Approve student registrations
  * Publish announcements
  * View email logs
* **Lecturer**

  * Create, edit, publish, and clone exams
  * Add MCQ and text questions
  * Grade text answers
  * View student attempt status and results
  * Export exam results (CSV)
* **Student**

  * Take timed exams assigned to their class
  * Resume in-progress exams
  * View submissions and results

### Exams & Assessment

* Timed exams with automatic expiry
* MCQ auto-scoring
* Text answer grading workflow
* Class-based access control
* Exam cloning for reuse across classes/batches

### UX & System

* Responsive design (mobile-friendly)
* Light / Dark theme toggle
* Bilingual interface (English / Malay)
* Role-based announcements
* Email notifications with logging
* Breadcrumb navigation
* Pending registration approval flow

---

## 🛠 Tech Stack

* **Backend**: Laravel 11 (PHP 8.2+)
* **Auth**: Laravel Breeze (Blade)
* **Frontend**: Blade + Tailwind CSS (no JS frameworks)
* **Database**: MySQL / PostgreSQL (configurable)
* **Mail**: Laravel Mail (log/mailtrap supported)
* **Build Tools**: Vite

---

## 🚀 Installation & Setup

### Prerequisites

* PHP 8.2 or higher
* Composer
* Node.js & npm
* MySQL / PostgreSQL

### Steps

```bash
# Clone repository
git clone <repository-url>
cd online-exam-portal

# Install backend dependencies
composer install

# Install frontend dependencies
npm install
npm run dev

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

# Run migrations & seed data
php artisan migrate:fresh --seed

# Start server
php artisan serve
```

Access the app at:
`http://127.0.0.1:8000`

---

## 👤 Demo Accounts (Local Environment)

> Visible on the welcome page when `APP_ENV=local`

| Role     | Email                                               | Password |
| -------- | --------------------------------------------------- | -------- |
| Admin    | [admin@example.com](mailto:admin@example.com)       | password |
| Lecturer | [lecturer@example.com](mailto:lecturer@example.com) | password |
| Student  | [student1@example.com](mailto:student1@example.com) | password |
| Student  | [student2@example.com](mailto:student2@example.com) | password |

---

## 🧭 Main User Flows

### Admin

1. Create classes and subjects
2. Assign subjects to classes
3. Create lecturers and students
4. Approve student registrations
5. Publish announcements

### Lecturer

1. Create exams for a class + subject
2. Add questions (MCQ / Text)
3. Publish exam (optional student notification)
4. Review attempts and grade text answers
5. Export results (CSV)
6. Clone exams for reuse

### Student

1. Register (pending approval)
2. Take assigned exams
3. Resume in-progress attempts
4. View results after submission/grading

---

## 🌐 Localization & Theme

* Language switch: **English / Malay**
* Theme switch: **Light / Dark**
* Preferences persist across pages (including auth screens)

> UI is bilingual; exam content language is defined by the lecturer.

---

## ⚠️ Notes & Assumptions

* Public registration creates **pending student accounts** requiring admin approval
* One attempt per student per exam
* Admin does not manage exams directly (academic ownership stays with lecturers)
* Email bodies are **not stored**, only logs/metadata
* No background queues required (emails sent synchronously)

---

## 🔒 Security & Access Control

* Role-based middleware and policies
* Students restricted to their assigned class exams
* Lecturers restricted to their own exams
* Admin-only access to system management

---

## 📌 Out of Scope (Intentionally)

* Real-time proctoring
* Question randomization
* Multi-attempt exams
* Plagiarism detection
* Frontend JS frameworks (Vue/React)

---

## 📄 License

This project is provided for **assessment and educational purposes**.

---
