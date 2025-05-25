# Judging System - LAMP Stack Implementation

## Overview
A complete judging system built using **PHP**, **MySQL**, and **vanilla JavaScript**. This is a **full-stack application** where:

- PHP files contain both backend logic **and** frontend templates.
- JavaScript is embedded directly in PHP files for simplicity.
- MySQL handles persistent data storage.

---

## 🔧 Setup Instructions

### Requirements
- PHP 8.0+
- MySQL 5.7+
- Apache/Nginx (or use PHP built-in server)

---

## Live Demo
[Access the live application here](https://judging-system-2.onrender.com)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/judging-system.git
   cd judging-system
   # 2. Copy to web root (better than direct clone to /var/www/html)
   sudo rsync -avz ./ /var/www/html/judging-system/ --exclude='.git'

**Set secure permissions**
sudo chown -R www-data:www-data /var/www/html/judging-system
sudo find /var/www/html/judging-system -type d -exec chmod 755 {} \;
sudo find /var/www/html/judging-system -type f -exec chmod 644 {} \;

**Special permissions for writeable folders**
sudo chmod -R 775 /var/www/html/judging-system/storage  # If you have logs/cache
   ```
2. **Create the database**
   ```bash
   # Create database and user (MySQL example)
    mysql -u root -p -e "CREATE DATABASE judging_system;"
    mysql -u root -p -e "CREATE USER 'judge_app'@'localhost' IDENTIFIED BY 'securepassword';"
    mysql -u root -p -e "GRANT ALL PRIVILEGES ON judging_system.* TO 'judge_app'@'localhost';" 

   # Import schema
    mysql -u root -p judging_system < sql/schema.sql

    # Optional: Load sample data
   mysql -u root -p judging_system < sql/sample_data.sql

   ```

3. **Configure database credentials**
   ```bash
   cp includes/config.example.php includes/config.php
   Edit includes/config.php with your database credentials:
   php
   <?php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'judging_system');
   define('DB_USER', 'judging_user');
   define('DB_PASS', 'SecurePassword123!');
   
   ```

4. **Start development server (PHP built-in)**
   ```bash
   php -S localhost:8000 router.php
   ```
   **Start Apache**
   ```bash
   sudo systemctl restart apache2
   ```

---
## 6️⃣ Troubleshooting Common Issues
Database Connection Errors:

bash
# Test your DB connection
mysql -u judge_app -psecurepassword judging_system -e "SHOW TABLES;"
File Permissions:

bash
chmod -R 755 storage/ logs/
chown -R www-data:www-data .  # For Apache
Missing Dependencies:

bash
# On Ubuntu/Debian
sudo apt install php-mysql php-curl php-mbstring


## 🗄️ Database Schema

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judge_id INT NOT NULL,
    score INT NOT NULL CHECK (score BETWEEN 1 AND 100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (judge_id) REFERENCES judges(id),
    UNIQUE KEY unique_judge_user (judge_id, user_id)
);
```

---

## 🎨 Design Choices

### Frontend/Backend Structure
- **Mixed Architecture**: Each PHP file includes backend logic and HTML/CSS/JS.
- **Why**: Simpler and faster for small-scale LAMP stack apps.

### Key Decisions
- **Database**
  - InnoDB for transactions
  - `CHECK` constraints for score validation
  - Unique judge-user scoring enforced
- **Security**
  - Prepared statements to prevent SQL injection
  - Basic input sanitization
- **JavaScript**
  - Vanilla JS directly embedded for DOM manipulation

---

## 🤔 Assumptions
- No authentication system (demo purposes only)
- Judges and participants are preloaded
- Running locally in PHP 8.0+ environment

---

## 🚀 Future Enhancements
If expanded further, features could include:
- Authentication (sessions or JWT)
- Decoupled frontend (React/Vue) with API
- CSV import/export
- WebSocket-based real-time updates
- Responsive design for mobile
- Automated testing suite

---



## 🔗 Access Points

- **Admin Panel**: `/judging-system/admin/` → Manage judges
- **Judge Portal**: `/judging-system/judges/` → Submit scores
- **Public Scoreboard**: `/judging-system/public/scoreboard.php` → View results

---

## License
MIT License