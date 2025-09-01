<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management System API</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        .api-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            text-align: left;
        }
        .endpoint {
            background: #e9ecef;
            padding: 0.5rem;
            border-radius: 4px;
            margin: 0.5rem 0;
            font-family: monospace;
        }
        .status {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 Teacher Management System API</h1>
        <p class="status">✅ API is running successfully!</p>
        
        <div class="api-info">
            <h3>Available Endpoints:</h3>
            
            <h4>Authentication:</h4>
            <div class="endpoint">POST /api/auth/register - User registration</div>
            <div class="endpoint">POST /api/auth/login - User login</div>
            <div class="endpoint">GET /api/auth/profile - Get user profile (Protected)</div>
            <div class="endpoint">POST /api/auth/logout - User logout (Protected)</div>
            
            <h4>Teachers:</h4>
            <div class="endpoint">POST /api/teachers - Create teacher (Protected)</div>
            <div class="endpoint">GET /api/teachers - List all teachers (Protected)</div>
            <div class="endpoint">GET /api/teachers/{id} - Get teacher details (Protected)</div>
            <div class="endpoint">PUT /api/teachers/{id} - Update teacher (Protected)</div>
            <div class="endpoint">DELETE /api/teachers/{id} - Delete teacher (Protected)</div>
            
            <h4>Users:</h4>
            <div class="endpoint">GET /api/users - List all users (Protected)</div>
            <div class="endpoint">GET /api/users/{id} - Get user details (Protected)</div>
        </div>
        
        <p><strong>Frontend:</strong> <a href="http://localhost:3000" target="_blank">React App</a></p>
        <p><strong>Database:</strong> MySQL - teacher_auth_db</p>
    </div>
</body>
</html>
