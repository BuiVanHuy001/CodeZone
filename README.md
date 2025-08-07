# CodeZone - Online Programming Learning Platform

CodeZone is a web-based learning platform developed to support students and instructors in teaching and learning
programming more effectively. Built with Laravel 12 and Livewire 3, CodeZone offers modern features like interactive
lessons, auto-graded coding assignments, and role-based course management.

---

## 🎨 UI Templates Used

- **Client**: [HiStudy - Online Courses & Education Template](https://rainbowit.net/html/histudy/)
- **Admin**: [Vuexy - Admin Dashboard Template](https://demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/)

---

## 🚀 Features

- 🎓 Role-based system: Admin, Instructor, Student, Organization
- 📚 Course creation and management with modules & lessons
- 🎥 Multiple lesson types: video, document, quiz, programming assignment
- 🧠 Quiz engine: Multiple choice and True/False questions
- 💻 Code assignment with auto-evaluation using test cases
- 📈 Learning progress tracking
- 📜 Certification generation upon course completion
- 📅 Organization-based course batches (start/end dates)
- 🔐 Access control for private enterprise courses
- 📱 Responsive user interface using Tailwind CSS

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

## 📦 Installation

```bash
# Clone the repository
git clone https://github.com/BuiVanHuy001/CodeZone.git
cd codezone

# Install dependencies
composer install
npm install

# Create .env file
cp .env.example .env

# Generate key
php artisan key:generate

# Start local server
php artisan serve & npm run dev
```

---

## 🔐 Default Login Accounts (if seeded)

| Role       | Email               | Password  |
|------------|---------------------|-----------|
| Student    | student@test.com    | password  |
| Instructor | instructor@test.com | password  |

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

---
