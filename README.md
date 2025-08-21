
# CodeZone - Online Programming Learning Platform

**CodeZone** is a web-based learning platform designed to support students and instructors in teaching and learning
programming more effectively.  
Built with **Laravel 12** and **Livewire 3**, CodeZone offers modern features like interactive lessons, auto-graded
coding assignments, and role-based course management.

---

## 🎨 UI Templates Used

- **Client**: [HiStudy - Online Courses & Education Template](https://rainbowit.net/html/histudy/)
- **Admin**: [Vuexy - Admin Dashboard Template](https://demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/)

---

## 🚀 Features

- 🎓 **Role-based system**: Admin, Instructor, Student, Organization
- 📚 **Course creation & management** with modules and lessons
- 🎥 **Multiple lesson types**: Video, Document, Quiz, Programming Assignment
- 🧠 **Quiz engine**: Multiple choice & True/False questions
- 💻 **Code assignments** with auto-evaluation using test cases
- 📈 **Learning progress tracking**
- 📜 **Certification generation** upon course completion
- 📅 **Organization-based course batches** with start/end dates
- 🔐 **Access control** for private enterprise courses

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

# (Optional) Import sample database
# Execute the SQL script from `database/codezone.sql`
# Replace the public folder in storage/app with the one from Google Drive:
# https://drive.google.com/drive/folders/1owAxrNEtvWm9NyBgthAGN-gIZnMqCwx9?usp=drive_link

# Start development servers
php artisan serve & npm run dev
````

---

## 🔐 Default Login Accounts (if seeded)

| Role         | Email              | Password |
|--------------|--------------------|----------|
| Student      | oanh@zalo.com      | password |
| Instructor   | huy@codezone.com   | password |
| Organization | caodang@vietmy.com | password |

---

## 📌 Requirements

* PHP 8.2+
* Composer 2+
* Node.js 18+
* MySQL 5.7+

For **social login**, you must configure these variables in `.env`:

```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
```

---

## 📬 Contact & Contribution

For feedback, contributions, or bug reports:

* **Email**: [work.buivanhuy@gmail.com](mailto:work.buivanhuy@gmail.com)
* **GitHub Issues**: [Submit here](https://github.com/BuiVanHuy001/CodeZone/issues)

---

## 👨‍💻 Author

**Bui Van Huy**

* GitHub: [buivanhuy001](https://github.com/buivanhuy001)

---
