import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

const Dashboard = () => {
  const [stats, setStats] = useState({
    totalUsers: 0,
    totalTeachers: 0
  });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchStats();
  }, []);

  const fetchStats = async () => {
    try {
      const token = localStorage.getItem('token');
      const headers = { Authorization: `Bearer ${token}` };

              const [usersResponse, teachersResponse] = await Promise.all([
            axios.get('/users', { headers }),
            axios.get('/teachers', { headers })
        ]);

      setStats({
        totalUsers: usersResponse.data.data?.length || 0,
        totalTeachers: teachersResponse.data.data?.length || 0
      });
    } catch (error) {
      console.error('Error fetching stats:', error);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="card">
        <h2>📊 Dashboard</h2>
        <p>Loading...</p>
      </div>
    );
  }

  return (
    <div>
      <h1 style={{ marginBottom: '30px', color: '#333' }}>🎓 Welcome to Teacher Management System</h1>
      
      <div className="dashboard-stats">
        <div className="stat-card">
          <div className="stat-number">{stats.totalUsers}</div>
          <div className="stat-label">Total Users</div>
        </div>
        
        <div className="stat-card">
          <div className="stat-number">{stats.totalTeachers}</div>
          <div className="stat-label">Total Teachers</div>
        </div>
      </div>

      <div className="card">
        <h3>🚀 Quick Actions</h3>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '20px', marginTop: '20px' }}>
          <Link to="/add-teacher" className="btn btn-primary" style={{ textAlign: 'center', textDecoration: 'none', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            ➕ Add New Teacher
          </Link>
          
          <Link to="/teachers" className="btn btn-success" style={{ textAlign: 'center', textDecoration: 'none', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            👥 View All Teachers
          </Link>
          
          <Link to="/users" className="btn btn-primary" style={{ textAlign: 'center', textDecoration: 'none', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            👤 View All Users
          </Link>
        </div>
      </div>

      <div className="card">
        <h3>📋 System Overview</h3>
        <p>This Teacher Management System provides comprehensive functionality for managing teacher profiles and user accounts.</p>
        
        <h4 style={{ marginTop: '20px', marginBottom: '10px' }}>Features:</h4>
        <ul style={{ marginLeft: '20px' }}>
          <li>Secure user authentication with JWT tokens</li>
          <li>Teacher profile management with detailed information</li>
          <li>User account management</li>
          <li>Responsive and modern UI design</li>
          <li>Real-time data synchronization</li>
        </ul>
      </div>
    </div>
  );
};

export default Dashboard;
