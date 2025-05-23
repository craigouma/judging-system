
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

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/judging-system.git
   cd judging-system
   ```

2. **Create the database**
   ```bash
   mysql -u root -p < sql/schema.sql
   ```

3. **Configure database credentials**
   ```bash
   cp includes/config.example.php includes/config.php
   nano includes/config.php
   ```

4. **Start development server (PHP built-in)**
   ```bash
   php -S localhost:8000 router.php
   ```

---

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

## 📦 Deployment

For live access (optional):

- **Free hosting**: [000webhost](https://www.000webhost.com/), [InfinityFree](https://infinityfree.net/)
- **Paid VPS**: [DigitalOcean](https://digitalocean.com), [Linode](https://linode.com) ($5/month)
- **Local**: Share demo video

### To deploy:
- Upload all files to host
- Import `sql/schema.sql` into your database
- Edit `includes/config.php` with production credentials
- Set permissions: `755` for directories, `644` for files

---

## 🔗 Access Points

- **Admin Panel**: `/admin` → Manage judges
- **Judge Portal**: `/judges` → Submit scores
- **Public Scoreboard**: `/scoreboard` → View results

---

## License
MIT License