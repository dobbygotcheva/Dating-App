# Mismatch Dating Website

A PHP-based dating website where "opposites attract" - users are matched based on their opposite preferences from a questionnaire.

## 🌟 Features

- **User Registration & Authentication**: Secure signup and login system
- **Profile Management**: Create, edit, and view user profiles with profile pictures
- **Questionnaire System**: Answer preference questions to find matches
- **Smart Matching**: Algorithm matches users based on opposite preferences
- **Modern UI**: Beautiful, responsive design with gradient backgrounds
- **Profile Pictures**: Upload and display user profile images
- **Regional Topics**: Customized questionnaire topics for different regions

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- SQLite3 extension for PHP
- Web server (Apache/Nginx) or PHP built-in server

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/mismatch-dating.git
   cd mismatch-dating
   ```

2. **Set up the database**
   ```bash
   cd mismatch
   php setup_sqlite.php
   ```

3. **Start the development server**
   ```bash
   # For Linux/Mac
   ./start_sqlite_server.sh
   
   # For Windows
   start_sqlite_server.bat
   ```

4. **Access the application**
   - Open your browser and go to `http://localhost:8000`
   - Register a new account
   - Complete the questionnaire
   - Start finding your perfect mismatches!

## 📁 Project Structure

```
mismatch/
├── images/                 # User uploaded profile pictures
├── mismatch/              # Nested directory (legacy)
├── *.php                  # Main application files
├── style.css              # Styling
├── mismatch.db            # SQLite database
├── appvars.php            # Application variables
├── connectvars.php        # Database connection
├── header.php             # Page header
├── footer.php             # Page footer
├── navmenu.php            # Navigation menu
└── startsession.php       # Session management

Root directory:
├── *.sql                  # Database schema files
├── *.sh                   # Server startup scripts
├── *.bat                  # Windows startup scripts
├── setup_*.php            # Database setup scripts
├── test_*.php             # Testing files
└── README files
```

## 🎯 Core Features Explained

### User Authentication
- Secure registration with validation
- Session-based login system
- Profile management with image uploads

### Questionnaire System
- Multiple choice questions across different categories
- Regional topic customization
- Response tracking and analysis

### Matching Algorithm
- Calculates mismatch percentages based on opposite responses
- Requires minimum 5 common questions for matching
- Sorts matches by compatibility score

### Modern UI/UX
- Responsive design that works on all devices
- Beautiful gradient backgrounds and modern styling
- Intuitive navigation and user experience

## 🛠️ Configuration

### Database Configuration
Edit `mismatch/connectvars.php`:
```php
define('DB_PATH', 'mismatch.db');
```

### File Upload Configuration
Edit `mismatch/appvars.php`:
```php
define('MM_UPLOADPATH', 'images/');
define('MM_MAXFILESIZE', 32768);
```

## 🧪 Testing

The project includes several test files for development:
- `test_connection.php` - Database connection testing
- `test_signup.php` - Registration testing
- `test_upload.php` - File upload testing
- `debug_mymismatch.php` - Debug matching functionality

## 🔧 Development

### Adding New Questions
1. Edit the SQL files in the root directory
2. Run the setup script to update the database
3. Update the questionnaire display logic

### Customizing Topics
Modify the topic files:
- `mismatch_topic.sqlite.sql` - Main topics
- `mismatch_category.sqlite.sql` - Categories

### Styling
All styling is in `mismatch/style.css` with modern CSS features:
- CSS Grid and Flexbox
- Gradient backgrounds
- Responsive design
- Modern animations

## 📸 Screenshots

The application features:
- Beautiful homepage with user showcase
- Modern questionnaire interface
- Profile management with image uploads
- Match display with compatibility scores
- Responsive design for all devices

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source.

## 🆘 Support

If you encounter any issues:
1. Check the troubleshooting section in `INSTALL.md`
2. Review the test files for debugging
3. Open an issue on GitHub

## 🎉 Acknowledgments

- Built with PHP and SQLite
- Modern CSS for beautiful UI
- Responsive design principles
- User experience best practices

---

**Happy matching! Find your perfect opposite! 💕** 
