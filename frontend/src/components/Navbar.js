import React from 'react';
import { Link, useLocation } from 'react-router-dom';

const Navbar = ({ user, onLogout }) => {
  const location = useLocation();

  const isActive = (path) => {
    return location.pathname === path ? 'active' : '';
  };

  return (
    <nav className="navbar">
      <div className="container">
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
          <Link to="/dashboard" className="navbar-brand">
            🎓 Teacher Management System
          </Link>
          
          <div style={{ display: 'flex', alignItems: 'center' }}>
            <ul className="navbar-nav">
              <li>
                <Link to="/dashboard" className={isActive('/dashboard')}>
                  Dashboard
                </Link>
              </li>
              <li>
                <Link to="/teachers" className={isActive('/teachers')}>
                  Teachers
                </Link>
              </li>
              <li>
                <Link to="/users" className={isActive('/users')}>
                  Users
                </Link>
              </li>
              <li>
                <Link to="/add-teacher" className={isActive('/add-teacher')}>
                  Add Teacher
                </Link>
              </li>
            </ul>
            
            <div style={{ marginLeft: '20px', display: 'flex', alignItems: 'center' }}>
              <span style={{ marginRight: '15px', color: '#666' }}>
                Welcome, {user?.first_name}!
              </span>
              <button onClick={onLogout} className="btn btn-danger">
                Logout
              </button>
            </div>
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
