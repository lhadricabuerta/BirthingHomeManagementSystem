# Birthing Home Management System

A comprehensive web-based management system designed for birthing homes and maternal health facilities. This system streamlines appointment scheduling, patient management, inventory tracking, and automated patient communication through an intelligent chatbot integration.

## 🚀 Features

### Core Modules
- **Appointment Management** - Schedule, track, and manage patient appointments with calendar integration
- **Patient Records System** - Secure storage and management of patient information and medical history
- **Inventory Management** - Track medical supplies, equipment, and medications with low-stock alerts
- **Staff Administration** - Manage staff accounts, roles, and access permissions
- **Automated Notifications** - AI-powered Messenger chatbot for appointment reminders and patient communication

### Key Highlights
- Role-based access control (Admin, Staff, Patient)
- Real-time appointment scheduling and conflict detection
- Automated SMS/Messenger notifications via n8n workflows
- AI agent integration for intelligent patient responses
- Responsive design for desktop and mobile access
- Secure authentication and data encryption

## 🛠️ Technologies Used

### Backend
- **Framework:** Laravel 10.x
- **Database:** MySQL
- **Server:** Ubuntu Server (Apache)
- **Authentication:** Laravel Sanctum

### Frontend
- **HTML5, CSS3, JavaScript**
- **Bootstrap 5** - Responsive UI framework
- **jQuery** - Dynamic interactions

### Automation & Integration
- **n8n** - Workflow automation platform
- **AI Agent Nodes** - Intelligent chatbot responses
- **Messenger API** - Patient communication
- **Webhook Integration** - Real-time notifications

### DevOps & Deployment
- **Git/GitHub** - Version control
- **SSH/SFTP** - Server management
- **SSL Certificate** - Secure HTTPS connection
- **Apache Configuration** - Web server setup

## 📋 Prerequisites

Before installation, ensure you have:
- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM
- Apache/Nginx web server
- Git

## 🔧 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/birthing-home-management.git
cd birthing-home-management
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=birthing_home_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations
```bash
# Create database tables
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
# or for development
npm run dev
```

### 7. Start Development Server
```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## 👥 Default Login Credentials

**Admin Account:**
- Email: admin@birthinghame.com
- Password: admin123

**Staff Account:**
- Email: staff@birthinghame.com
- Password: staff123

⚠️ **Important:** Change these credentials immediately after first login!

## 📁 Project Structure

```
birthing-home-management/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/              # Database models
│   └── Services/            # Business logic
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Sample data seeders
├── public/                  # Public assets
├── resources/
│   ├── views/              # Blade templates
│   └── js/                 # JavaScript files
├── routes/
│   └── web.php             # Web routes
└── storage/                # File storage
```

## 🔐 Security Features

- Password hashing with bcrypt
- CSRF protection on all forms
- SQL injection prevention through Eloquent ORM
- XSS protection
- Role-based access control (RBAC)
- Secure session management

## 🤝 Contributing

This is a capstone project for academic purposes. However, suggestions and feedback are welcome!

## 📄 License

This project is developed as part of academic requirements at Camarines Sur Polytechnic Colleges.

## 👨‍💻 Developer

**Jerald Ricabuerta**  
BS Information Technology Student  
Camarines Sur Polytechnic Colleges  

📧 Email: jerald.ricabuerta@email.com  
🔗 LinkedIn: [Your LinkedIn Profile]

## 🙏 Acknowledgments

- Camarines Sur Polytechnic Colleges - IT Department
- Project Advisers and Panel Members
- Birthing Home Partner Facility

---

⭐ If you find this project helpful, please consider giving it a star!

**Note:** This system is designed for educational purposes as part of a capstone project requirement.
