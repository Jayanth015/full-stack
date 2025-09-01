# 🎓 Teacher Management System

A complete full-stack application built with CodeIgniter 4 (Backend) and ReactJS (Frontend) featuring JWT authentication and comprehensive teacher management functionality.

## 🌟 Features

- **Secure Authentication**: JWT-based authentication system
- **User Management**: Register, login, and user profile management
- **Teacher Management**: Complete CRUD operations for teacher profiles
- **Database Relationships**: 1-1 relationship between users and teachers
- **Modern UI**: Responsive and beautiful React frontend
- **API Security**: Protected routes with JWT token validation
- **Data Validation**: Comprehensive input validation and error handling

##  Architecture

### Backend (CodeIgniter 4)
- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Authentication**: JWT tokens
- **API**: RESTful endpoints
- **Validation**: Built-in form validation

### Frontend (ReactJS)
- **Framework**: React 18
- **Routing**: React Router v6
- **HTTP Client**: Axios
- **Styling**: Custom CSS with modern design
- **State Management**: React Hooks

## 📁 Project Structure

```
├── app/                          # CodeIgniter application
│   ├── Config/                   # Configuration files
│   ├── Controllers/              # API controllers
│   ├── Models/                   # Database models
│   ├── Views/                    # Views and templates
│   ├── Filters/                  # Custom filters
│   └── Database/                 # Database migrations
├── frontend/                     # React frontend
│   ├── public/                   # Public assets
│   ├── src/                      # Source code
│   │   ├── components/           # React components
│   │   ├── App.js               # Main app component
│   │   └── index.js             # Entry point
│   └── package.json             # Dependencies
├── database/                     # Database files
│   └── teacher_auth_db.sql      # Database export
├── composer.json                 # PHP dependencies
└── README.md                     # Project documentation
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4+ or 8.0+
- MySQL 5.7+
- Node.js 14+
- Composer
- Web server (Apache/Nginx)

### Backend Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd teacher-management-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Database setup**
   ```bash
   # Create database
   mysql -u root -p < database/teacher_auth_db.sql
   
   # Or manually create database and import the SQL file
   ```

4. **Configure database**
   - Edit `app/Config/Database.php`
   - Update database credentials
   - Set database name to `teacher_auth_db`

5. **Run migrations**
   ```bash
   php spark migrate
   ```

6. **Start development server**
   ```bash
   php spark serve
   ```
   Backend will be available at: `http://localhost:8000`

### Frontend Setup

1. **Navigate to frontend directory**
   ```bash
   cd frontend
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Start development server**
   ```bash
   npm start
   ```
   Frontend will be available at: `http://localhost:3000`

## 🗄️ Database Schema

### auth_user Table
- `id` - Primary key (auto-increment)
- `email` - Unique email address
- `first_name` - User's first name
- `last_name` - User's last name
- `password` - Hashed password
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### teachers Table
- `id` - Primary key (auto-increment)
- `user_id` - Foreign key to auth_user.id
- `university_name` - University/college name
- `gender` - Gender (male/female/other)
- `year_joined` - Year joined the institution
- `department` - Department name
- `phone` - Contact phone number
- `address` - Full address
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## 🔌 API Endpoints

### Authentication
- `POST /api/auth/register` - User registration
- `POST /api/auth/login` - User login
- `GET /api/auth/profile` - Get user profile (Protected)
- `POST /api/auth/logout` - User logout (Protected)

### Teachers
- `POST /api/teachers` - Create teacher (Protected)
- `GET /api/teachers` - List all teachers (Protected)
- `GET /api/teachers/{id}` - Get teacher details (Protected)
- `PUT /api/teachers/{id}` - Update teacher (Protected)
- `DELETE /api/teachers/{id}` - Delete teacher (Protected)

### Users
- `GET /api/users` - List all users (Protected)
- `GET /api/users/{id}` - Get user details (Protected)

## 🔐 Authentication

The system uses JWT (JSON Web Tokens) for authentication:

1. **Login/Register**: User credentials are validated
2. **Token Generation**: JWT token is generated and returned
3. **Protected Routes**: Token must be included in Authorization header
4. **Token Format**: `Bearer <token>`

## 🎨 Frontend Features

- **Responsive Design**: Works on all device sizes
- **Modern UI**: Clean and intuitive interface
- **Navigation**: Easy navigation between different sections
- **Forms**: User-friendly forms with validation
- **Data Tables**: Organized display of information
- **Real-time Updates**: Immediate feedback on actions

## 🧪 Testing

### Backend Testing
```bash
# Run PHP tests
composer test
```

### Frontend Testing
```bash
cd frontend
npm test
```

## 📱 Usage

1. **Access the application**: Navigate to `http://localhost:3000`
2. **Register/Login**: Create an account or login with existing credentials
3. **Dashboard**: View system overview and quick actions
4. **Manage Teachers**: Add, view, edit, and delete teacher profiles
5. **User Management**: View all registered users
6. **Navigation**: Use the navigation bar to switch between sections

## 🔧 Configuration

### Environment Variables
- `JWT_SECRET`: Secret key for JWT token generation
- Database credentials in `app/Config/Database.php`

### Customization
- Modify validation rules in models
- Update UI styling in CSS files
- Add new fields to database schema
- Extend API endpoints as needed

## 🚨 Security Features

- **Password Hashing**: Bcrypt password hashing
- **JWT Tokens**: Secure token-based authentication
- **Input Validation**: Comprehensive input sanitization
- **SQL Injection Protection**: Prepared statements
- **CORS Protection**: Cross-origin request handling

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials
   - Ensure MySQL service is running
   - Verify database exists

2. **JWT Token Issues**
   - Check JWT_SECRET environment variable
   - Verify token format in requests
   - Check token expiration

3. **Frontend Build Errors**
   - Clear node_modules and reinstall
   - Check Node.js version compatibility
   - Verify all dependencies are installed

## 📈 Performance Optimization

- **Database Indexing**: Proper indexing on foreign keys
- **API Caching**: Implement caching for frequently accessed data
- **Frontend Optimization**: Code splitting and lazy loading
- **Image Optimization**: Compress and optimize images

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

## 👥 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

## 🎯 Future Enhancements

- **Email Verification**: User email verification system
- **Password Reset**: Forgot password functionality
- **File Upload**: Profile picture and document uploads
- **Advanced Search**: Filtering and search capabilities
- **Export Features**: Data export to various formats
- **Mobile App**: Native mobile application
- **Real-time Notifications**: WebSocket integration

---

**Happy Coding! 🚀**
