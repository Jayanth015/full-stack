# 🚀 Project Execution Steps

This document provides step-by-step instructions to run the Teacher Management System project.

## 📋 Prerequisites Check

Before starting, ensure you have the following installed:

- ✅ PHP 7.4+ or 8.0+
- ✅ MySQL 5.7+
- ✅ Node.js 14+
- ✅ Composer
- ✅ Git

## 🔧 Step 1: Project Setup

### 1.1 Clone/Download Project
```bash
# If using git
git clone <repository-url>
cd teacher-management-system

# Or extract the downloaded ZIP file
```

### 1.2 Verify Project Structure
Ensure you have the following structure:
```
├── app/                          # CodeIgniter backend
├── frontend/                     # React frontend
├── database/                     # Database files
├── composer.json                 # PHP dependencies
└── README.md                     # Documentation
```

## 🗄️ Step 2: Database Setup

### 2.1 Start MySQL Service
```bash
# Windows (XAMPP/WAMP)
# Start MySQL service from control panel

# Linux/Mac
sudo service mysql start
# or
sudo systemctl start mysql
```

### 2.2 Create Database
```bash
# Option 1: Using SQL file (Recommended)
mysql -u root -p < database/teacher_auth_db.sql

# Option 2: Manual creation
mysql -u root -p
CREATE DATABASE teacher_auth_db;
USE teacher_auth_db;
# Then copy and paste the SQL content from database/teacher_auth_db.sql
```

### 2.3 Verify Database Creation
```bash
mysql -u root -p
SHOW DATABASES;
USE teacher_auth_db;
SHOW TABLES;
# Should show: auth_user, teachers
```

## ⚙️ Step 3: Backend Setup (CodeIgniter)

### 3.1 Install PHP Dependencies
```bash
# Navigate to project root
cd teacher-management-system

# Install dependencies
composer install
```

### 3.2 Configure Database Connection
Edit `app/Config/Database.php`:
```php
'hostname' => 'localhost',
'username' => 'root',           // Your MySQL username
'password' => '',               // Your MySQL password
'database' => 'teacher_auth_db',
```

### 3.3 Set JWT Secret (Optional)
Create `.env` file in project root:
```env
JWT_SECRET=your-super-secret-key-here
```

### 3.4 Run Database Migrations
```bash
php spark migrate
```

### 3.5 Start Backend Server
```bash
php spark serve
```

**✅ Backend should now be running at: http://localhost:8000**

### 3.6 Test Backend API
Open browser and navigate to: `http://localhost:8000`
You should see the API welcome page with available endpoints.

## 🎨 Step 4: Frontend Setup (React)

### 4.1 Install Node Dependencies
```bash
# Navigate to frontend directory
cd frontend

# Install dependencies
npm install
```

### 4.2 Start Frontend Development Server
```bash
npm start
```

**✅ Frontend should now be running at: http://localhost:3000**

### 4.3 Verify Frontend
- Browser should automatically open to `http://localhost:3000`
- You should see the login page
- If not, manually navigate to the URL

## 🧪 Step 5: Testing the Application

### 5.1 Test User Registration
1. Navigate to `http://localhost:3000/register`
2. Fill in the registration form:
   - Email: `test@example.com`
   - First Name: `Test`
   - Last Name: `User`
   - Password: `password123`
   - Confirm Password: `password123`
3. Click "Register"
4. Should see success message

### 5.2 Test User Login
1. Navigate to `http://localhost:3000/login`
2. Use the credentials from registration:
   - Email: `test@example.com`
   - Password: `password123`
3. Click "Login"
4. Should redirect to dashboard

### 5.3 Test Dashboard
1. After login, you should see the dashboard
2. Check the statistics (Total Users, Total Teachers)
3. Verify navigation menu is visible

### 5.4 Test Teacher Management
1. Click "Add Teacher" in navigation
2. Fill in the teacher form with sample data:
   - Email: `teacher@university.edu`
   - First Name: `John`
   - Last Name: `Doe`
   - Password: `password123`
   - University: `University of Technology`
   - Gender: `Male`
   - Year Joined: `2020`
   - Department: `Computer Science`
   - Phone: `1234567890`
   - Address: `123 Main St, Tech City, TC 12345`
3. Click "Add Teacher"
4. Should redirect to teachers list

### 5.5 Test Data Tables
1. Navigate to "Teachers" page
2. Verify the newly created teacher appears
3. Navigate to "Users" page
4. Verify both user and teacher user appear

## 🔍 Step 6: API Testing (Optional)

### 6.1 Test with Postman/Insomnia
Use these endpoints for testing:

**Registration:**
```
POST http://localhost:8000/api/auth/register
Content-Type: application/json

{
  "email": "api@test.com",
  "first_name": "API",
  "last_name": "Test",
  "password": "password123"
}
```

**Login:**
```
POST http://localhost:8000/api/auth/login
Content-Type: application/json

{
  "email": "api@test.com",
  "password": "password123"
}
```

**Get Teachers (with token):**
```
GET http://localhost:8000/api/teachers
Authorization: Bearer <token_from_login>
```

## 🚨 Troubleshooting Common Issues

### Issue 1: Database Connection Error
**Symptoms:** Backend shows database connection error
**Solution:**
- Check MySQL service is running
- Verify database credentials in `app/Config/Database.php`
- Ensure database `teacher_auth_db` exists

### Issue 2: Composer Install Fails
**Symptoms:** `composer install` shows errors
**Solution:**
- Update Composer: `composer self-update`
- Clear cache: `composer clear-cache`
- Check PHP version: `php -v`

### Issue 3: Frontend Build Errors
**Symptoms:** `npm start` shows errors
**Solution:**
- Clear node_modules: `rm -rf node_modules package-lock.json`
- Reinstall: `npm install`
- Check Node.js version: `node -v`

### Issue 4: CORS Issues
**Symptoms:** Frontend can't connect to backend
**Solution:**
- Ensure backend is running on port 8000
- Check proxy setting in `frontend/package.json`
- Verify both servers are running simultaneously

### Issue 5: JWT Token Issues
**Symptoms:** Authentication fails
**Solution:**
- Check JWT_SECRET is set
- Verify token format in requests
- Check token expiration

## 📱 Step 7: Production Deployment (Optional)

### 7.1 Build Frontend for Production
```bash
cd frontend
npm run build
```

### 7.2 Configure Web Server
- Copy `frontend/build` contents to web server directory
- Configure Apache/Nginx for backend API
- Set up environment variables

## ✅ Verification Checklist

- [ ] Database created and tables exist
- [ ] Backend server running on port 8000
- [ ] Frontend server running on port 3000
- [ ] User registration working
- [ ] User login working
- [ ] Dashboard displaying correctly
- [ ] Teacher creation working
- [ ] Data tables displaying data
- [ ] Navigation working between pages
- [ ] API endpoints responding correctly

## 🎯 Next Steps

After successful setup:

1. **Customize the application**:
   - Modify validation rules
   - Add new fields to forms
   - Update styling and branding

2. **Extend functionality**:
   - Add more user roles
   - Implement file uploads
   - Add reporting features

3. **Deploy to production**:
   - Set up production database
   - Configure web server
   - Set environment variables

## 📞 Support

If you encounter issues:

1. Check the troubleshooting section above
2. Review error logs in browser console and terminal
3. Verify all prerequisites are met
4. Check the README.md for additional information

---

**🎉 Congratulations! Your Teacher Management System is now running successfully!**
