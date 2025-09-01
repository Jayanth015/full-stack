import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Teachers = () => {
  const [teachers, setTeachers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchTeachers();
  }, []);

  const fetchTeachers = async () => {
    try {
      const token = localStorage.getItem('token');
              const response = await axios.get('/teachers', {
        headers: { Authorization: `Bearer ${token}` }
      });
      
      if (response.data.status === 'success') {
        setTeachers(response.data.data);
      }
    } catch (err) {
      setError('Failed to fetch teachers');
      console.error('Error fetching teachers:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Are you sure you want to delete this teacher?')) {
      try {
        const token = localStorage.getItem('token');
                    await axios.delete(`/teachers/${id}`, {
          headers: { Authorization: `Bearer ${token}` }
        });
        
        setTeachers(teachers.filter(teacher => teacher.id !== id));
      } catch (err) {
        alert('Failed to delete teacher');
        console.error('Error deleting teacher:', err);
      }
    }
  };

  if (loading) {
    return (
      <div className="card">
        <h2>👥 Teachers</h2>
        <p>Loading...</p>
      </div>
    );
  }

  if (error) {
    return (
      <div className="card">
        <h2>👥 Teachers</h2>
        <div className="alert alert-danger">{error}</div>
      </div>
    );
  }

  return (
    <div>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px' }}>
        <h1 style={{ color: '#333' }}>👥 Teachers</h1>
        <span className="btn btn-success" style={{ cursor: 'default' }}>
          Total: {teachers.length}
        </span>
      </div>

      {teachers.length === 0 ? (
        <div className="card">
          <p style={{ textAlign: 'center', color: '#666' }}>No teachers found.</p>
        </div>
      ) : (
        <div className="card">
          <table className="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>University</th>
                <th>Department</th>
                <th>Gender</th>
                <th>Year Joined</th>
                <th>Phone</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {teachers.map((teacher) => (
                <tr key={teacher.id}>
                  <td>{teacher.id}</td>
                  <td>{teacher.first_name} {teacher.last_name}</td>
                  <td>{teacher.email}</td>
                  <td>{teacher.university_name}</td>
                  <td>{teacher.department}</td>
                  <td>{teacher.gender}</td>
                  <td>{teacher.year_joined}</td>
                  <td>{teacher.phone}</td>
                  <td>
                    <button
                      onClick={() => handleDelete(teacher.id)}
                      className="btn btn-danger"
                      style={{ padding: '5px 10px', fontSize: '14px' }}
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
};

export default Teachers;
