@echo off
echo Starting Teacher Management System...
echo.

echo Starting Backend Server (PHP) on port 8000...
start "Backend Server" cmd /k "cd /d %~dp0 && php -S localhost:8000"

echo Waiting 3 seconds for backend to start...
timeout /t 3 /nobreak > nul

echo Starting Frontend Server (React) on port 3000...
start "Frontend Server" cmd /k "cd /d %~dp0frontend && set DISABLE_ESLINT_PLUGIN=true && npm start"

echo.
echo Both servers are starting...
echo Backend: http://localhost:8000
echo Frontend: http://localhost:3000
echo.
echo Press any key to close this window...
pause > nul
