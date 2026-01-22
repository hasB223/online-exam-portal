---

# Online Exam Portal

A role-based online examination system built with **Laravel 11 + Breeze**, designed for administrators, lecturers, and students to manage exams, conduct assessments, and review results efficiently.

The system focuses on clear workflows, access control, and usability, with support for **timed exams**, **auto-scoring**, **manual grading**, **bilingual UI**, and **dark/light mode**.

The system is intentionally designed with clear separation of responsibilities between administrators, lecturers, and students, prioritizing maintainability and realistic academic workflows over feature overload.

---

## Key Features

### Roles & Access

* **Admin**
  * Manage users, roles, classes, and subjects
  * Approve/activate pending student registrations and assign classes
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
* Light / Dark theme toggle (welcome + auth pages included)
* Bilingual interface (English / Malay)
* Role-based announcements
* Email notifications with logging
* Breadcrumb navigation
* Pending registration approval flow (admin-controlled onboarding)

---

## Tech Stack

* **Backend**: Laravel 11 (PHP 8.2+)
* **Auth**: Laravel Breeze (Blade)
* **Frontend**: Blade + Tailwind CSS (no JS frameworks)
* **Database**: MySQL / PostgreSQL (configurable)
* **Mail**: Laravel Mail (log/mailtrap supported)
* **Build Tools**: Vite

---

## Installation & Setup

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

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

# Optional mail for local testing (logs emails to storage/logs/laravel.log)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Online Exam Portal"

# Run migrations & seed data
php artisan migrate:fresh --seed

# Build assets (dev)
npm run dev

# Start server
php artisan serve
```

Production build:
```bash
npm run build
```

Access the app at:
`http://127.0.0.1:8000`

---

## Demo Accounts (Local Environment)

> Visible on the welcome page when `APP_ENV=local` (seeded in `DatabaseSeeder`)

| Role     | Email                                               | Password |
| -------- | --------------------------------------------------- | -------- |
| Admin    | [admin@example.com](mailto:admin@example.com)       | password |
| Lecturer | [lecturer@example.com](mailto:lecturer@example.com) | password |
| Student  | [student1@example.com](mailto:student1@example.com) | password |
| Student  | [student2@example.com](mailto:student2@example.com) | password |

---

## Main User Flows

### Admin
1. Create classes and subjects
2. Assign subjects to classes
3. Create lecturers and students
4. Approve student registrations and assign classes
5. Publish announcements

### Lecturer
1. Create exams for a class + subject
2. Add questions (MCQ / Text)
3. Publish exam (optional student notification)
4. Review attempts and grade text answers
5. Export exam results (CSV, per exam)
6. Clone exams for reuse

### Student
1. Register (pending approval)
2. Take assigned exams
3. Resume in-progress attempts
4. View results after submission/grading

---

## Localization & Theme

* Language switch: **English / Malay** (top-right controls on welcome/auth screens)
* Theme switch: **Light / Dark**
* Preferences persist across pages (including auth screens)

> UI is bilingual; exam content language is defined by the lecturer.

---

## Notes & Assumptions

* Public registration creates **pending student accounts** requiring admin approval + class assignment
* One attempt per student per exam
* Admin does not manage exams directly; academic ownership and grading remain with lecturers by design.
* Email bodies are **not stored**, only logs/metadata
* No background queues required (emails sent synchronously)

---

## Security & Access Control

* Role-based middleware and policies
* Students restricted to their assigned class exams
* Lecturers restricted to their own exams
* Admin-only access to system management

---

## Out of Scope (Intentionally)

* Real-time proctoring
* Question randomization
* Multi-attempt exams
* Plagiarism detection
* Frontend JS frameworks (Vue/React)

---

## Troubleshooting

* **Missing APP_KEY**: run `php artisan key:generate` and ensure `.env` is writable.
* **DB connection errors**: verify `DB_*` values and that the database exists.
* **Vite assets not loading**: run `npm install` then `npm run dev` (or `npm run build` for production).

---

## License

This project is provided for **assessment and educational purposes**.

---
