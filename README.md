### Under developement
# Schoolary

A **Laravel-based** School Management System where students can check their marks, enroll in courses, and manage their academic progress.

## 🚀 Features

- Student authentication (login/logout)
- Role-based access (Admin, Teacher, Student)
- Notifications for important updates
- Secure and scalable

## 🛠️ Installation

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/ammar-gohar/Schoolary.git
cd Schoolary
```

### 2️⃣ Install Dependencies

```bash
composer install
npm install
```

### 3️⃣ Set Up Environment

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4️⃣ Configure Database

Edit `.env` and update your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schoolary
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

Run migrations:

```bash
php artisan migrate --seed
```

### 5️⃣ Start the Development Server

```bash
php artisan serve
npm run dev
```
Visit: [**http://127.0.0.1:8000**](http://127.0.0.1:8000)

## 📌 Technologies Used

- **Laravel** - Backend Framework
- **MySQL** - Database
- **Bootstrap** - Frontend
- **Livewire** - For interactive UI


## 🤝 Contributing

Feel free to fork this repository and submit pull requests. Your contributions are welcome! 😊

