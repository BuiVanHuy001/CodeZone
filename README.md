
# 🌐 CodeZone - An Online Learning Platform

A modern online learning platform built with **Laravel 12**, featuring traditional email authentication, Google/Facebook login via **Laravel Socialite**, and dynamic user interface powered by **Livewire** and **Alpine.js** in a SPA-style experience.

---

## 🎨 UI Templates Used

- **Client**: [HiStudy - Online Courses & Education Template](https://rainbowit.net/html/histudy/)
- **Admin**: [Vuexy - Admin Dashboard Template](https://demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/)

---

## 🚀 Key Features

### 👤 User Authentication
- Register / Login / Logout using email
- Social authentication: Google, Facebook
- Role-based access: `Student` and `Instructor`

### 📚 Course Management
- Instructors:
    - Create, edit, and delete courses
    - Manage course content
- Students:
    - View enrolled courses
    - Learn through the interactive course interface

### ⚙️ Dynamic SPA-style UI
- Built with **Livewire 3** for seamless real-time updates
- Enhanced interactivity using **Alpine.js**
---

## 🧭 Project Structure Overview

```bash
app/
└── Http/
    └── Controllers/
        ├── Auth/                 # Email & Socialite authentication
        └── Client/
            ├── Instructor/       # Instructor controllers
            └── Student/          # Student controllers

resources/
└── views/
    ├── layouts/                 # Shared layouts (header, footer, etc.)
    └── client/
        ├── instructor/
        └── student/

routes/
└── web.php                      # Grouped routes by role
```

---

## 🛠️ Technologies Used

| Technology        | Purpose                                  |
|-------------------|-------------------------------------------|
| Laravel 12        | Backend framework                         |
| Livewire 3        | SPA-style dynamic frontend                |
| Alpine.js         | Lightweight frontend interactivity        |
| Laravel Socialite | Social login (Google, Facebook)           |
| SweetAlert2       | Beautiful alert popups                    |
| MySQL             | Database system                           |
| Vite              | Fast asset bundler                        |
| Tailwind CSS      | Utility-first CSS framework               |

---

## 🧪 How to Run the Project Locally

```bash
# Clone the repository
git clone https://github.com/yourname/online-learning-platform.git
cd online-learning-platform

# Install dependencies
composer install
npm install && npm run dev

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure your database in .env

# Run migrations and seeders
php artisan migrate --seed

# Start the development server
php artisan serve
```

---

## 🔐 Default Login Accounts (if seeded)

| Role       | Email               | Password  |
|------------|---------------------|-----------|
| Student    | student@test.com    | password  |
| Instructor | instructor@test.com | password  |

---

## 📚 Documentation & References

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Docs](https://livewire.laravel.com/)
- [Alpine.js Docs](https://alpinejs.dev/)
- [SweetAlert2 Docs](https://sweetalert2.github.io/)

---

## 📌 Notes

- Ensure your system runs PHP 8.2+, Node.js 18+, Composer 2+
- Social login requires the following keys in your `.env` file:
    - `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`
    - `FACEBOOK_CLIENT_ID`, `FACEBOOK_CLIENT_SECRET`

---

## 📬 Contact / Contributing

For feedback, contributions, or bug reports:

- Email: `work.buivanhuy@gmail.com`
- GitHub Issues

---

## 🧑‍💻 Author

**Bui Van Huy** – [GitHub](https://github.com/buivanhuy001)
**Nha "

---
