# Quick Start Guide - Teacher Management System

## 🚀 Quick Start (Recommended)

The easiest way to start the project is to use the batch file:

1. **Double-click** `start_servers.bat` in the project root
2. This will automatically start both servers
3. Wait for both servers to start (you'll see new command windows)
4. Open your browser and go to: **http://localhost:3000**

## 🔧 Manual Start

If you prefer to start servers manually:

### Backend (PHP API)
```bash
# In the project root directory
php -S localhost:8000
```

### Frontend (React)
```bash
# In a new terminal, navigate to frontend directory
cd frontend
set DISABLE_ESLINT_PLUGIN=true
npm start
```

## 🌐 Access Points

- **Frontend Application**: http://localhost:3000
- **Backend API**: http://localhost:8000
- **API Endpoints**: http://localhost:8000/api/*

## 🧪 Test the API

To verify the backend is working, run:
```bash
php test_api.php
```

## 📱 Features Available

1. **User Registration** - Create new user accounts
2. **User Login** - Authenticate with JWT tokens
3. **Teacher Management** - Add teachers with user accounts
4. **Data Tables** - View all users and teachers
5. **Dashboard** - System overview and statistics

## 🔑 Default Test Account

If you want to test the system:
- **Email**: test@example.com
- **Password**: testpass123

## 🛠️ Troubleshooting

### If servers don't start:
1. Make sure PHP is installed and in PATH
2. Make sure Node.js and npm are installed
3. Check if ports 8000 and 3000 are available
4. Try running the batch file as administrator

### If frontend has ESLint errors:
- The `DISABLE_ESLINT_PLUGIN=true` flag should resolve this
- If issues persist, check the package.json dependencies

### If backend API doesn't respond:
- Check if PHP server is running on port 8000
- Verify the simple_server.php file exists
- Check the data directory permissions

## 📁 Project Structure

```
├── simple_server.php          # Backend API server
├── start_servers.bat         # Quick start script
├── test_api.php              # API testing script
├── data/                     # JSON data storage
│   ├── users.json           # User data
│   └── teachers.json        # Teacher data
├── frontend/                 # React frontend
│   ├── src/                 # Source code
│   ├── package.json         # Dependencies
│   └── public/              # Public assets
└── README.md                 # Full documentation
```

## 🎯 Next Steps

1. Start the servers using `start_servers.bat`
2. Open http://localhost:3000 in your browser
3. Register a new user account
4. Explore the teacher management features
5. Test the API endpoints

## 📞 Support

If you encounter any issues:
1. Check the troubleshooting section above
2. Verify both servers are running
3. Check the browser console for frontend errors
4. Check the terminal output for backend errors

Happy coding! 🎉
