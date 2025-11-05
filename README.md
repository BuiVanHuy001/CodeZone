# 🎓 CodeZone — Online Programming Learning Platform ![Hackatime Badge](https://hackatime-badge.hackclub.com/U098ESP1YH5/CodeZone)

## 🚀 Project Overview

**CodeZone** is a Laravel-based online learning platform built as a **side project** to apply and deepen my
understanding of Laravel and modern PHP development.
Inspired by **[Udemy](https://www.udemy.com/)** and **[Coursera](https://www.coursera.org/)**, it features course
management, interactive learning, and real-time engagement.

---

## 🎨 UI Templates Used

* **Client**: [HiStudy - Online Courses & Education Template](https://rainbowit.net/html/histudy/)
* **Admin
  **: [Vuexy - Admin Dashboard Template](https://demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/)

---

## 🛠️ Features

### 🎓 Course Management
* Create courses with multiple modules and lessons.
* Support for video lessons, text content, and coding assessments.

### 👨‍🏫 Instructor System
* Dedicated instructor profiles with ratings, bio, and statistics.
* Instructor earnings and analytics (revenue, student count, course rating).

### 💻 Learning Experience

* Integrated quiz engine with multiple question types (MCQ, coding).
* Auto grading for programming exercises with sandbox execution.
* Result tracking and pass/fail logic per user attempt.

### 💬 Community & Engagement
* Nested comment system (up to 3 levels).
* Reactions (like/dislike) for reviews and comments.
* Real-time updates via Livewire.
* Review and rating system per course/instructor.

### 🔍 Catalog & Filtering
* Advanced filtering by category, instructor, price, and level.
* Sorting by popularity, latest, rating, or price.
* Search across titles, descriptions, and skills.

### 👤 User & Enrollment
* Role-based access (Student / Instructor / Admin).
* Secure authentication and enrollment management.
* Student dashboard to track progress and completed courses.

### 🧰 Admin Panel
* Admin dashboard (Vuexy template).
* Manage users, courses status.
* Visualized data using ApexCharts.
* Metrics: revenue, enrollments, course ratings, instructor performance.

---

## 🧩 Tech Stack

### ⚙️ Backend

| Technology     | Description                                    |
|----------------|------------------------------------------------|
| **PHP 8.2**    | Core programming language                      |
| **Laravel 12** | Modern PHP framework                           |
| **Livewire 3** | Reactive components for SPA-like interactivity |
| **MySQL**      | Relational database engine                     |

### 🔌 Core Laravel Packages

| Package                        | Purpose                              |
|--------------------------------|--------------------------------------|
| `laravel/socialite`            | OAuth login (Google, GitHub, etc.)   |
| `maatwebsite/excel`            | Excel import/export                  |
| `spatie/laravel-markdown`      | Render Markdown for lessons          |
| `james-heinrich/getid3`        | Media metadata analysis              |
| `buivanhuy/sweetalert-laravel` | SweetAlert2 integration              |

---

### 🎨 Frontend

| Technology                       | Description                  |
|----------------------------------|------------------------------|
| **Vite 6 + laravel-vite-plugin** | Modern frontend bundler      |
| **Alpine.js 3**                  | Lightweight reactivity layer |
| **Plyr**                         | HTML5 video/audio player     |

---

### 💻 Code Editor Integration

| Package             | Description                                  |
|---------------------|----------------------------------------------|
| **CodeMirror 6**    | Embedded programming editor                  |
| Supported languages | JavaScript, Python, PHP, Java, C++, Markdown |
| Theme               | `@codemirror/theme-one-dark`                 |
| **Shiki**           | Syntax highlighting for lessons              |

---

## 📦 Installation & Local Setup

```bash
# Clone the repository
git clone https://github.com/BuiVanHuy001/CodeZone.git
cd codezone

# Install dependencies
composer install
npm install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# (Optional) Import sample data
php artisan db:seed

# Copy the public folder from the linked Google Drive to storage/app/public:
# https://drive.google.com/drive/folders/1goptWKpEjREzeQdbbpVFHoQiBXGrM9TH?usp=sharing

# Start development servers
php artisan serve & npm run dev
```
---

### Test Accounts

| Role       | Email / Username          | Password |
|------------|---------------------------|----------|
| Instructor | taylorotwell@codezone.com | password |
| Student    | tu@example.com            | password |
| Admin      | admin                     | password |

## 👨‍💻 Author

**Bui Van Huy**
🔗 [GitHub Profile](https://github.com/buivanhuy001)
