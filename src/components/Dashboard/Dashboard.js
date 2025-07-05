import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './Dashboard.module.css';  // Uvoz CSS modula
 
function Dashboard() {
    const [users, setUsers] = useState([]);
    const [error, setError] = useState(null);
 
    useEffect(() => {
        const token = localStorage.getItem('token');
 
        axios.get('http://127.0.0.1:8000/api/users', {
            headers: {
                Authorization: `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Fetched users:', response.data);
            setUsers(response.data);
        })
        .catch(() => {
            setError('Failed to fetch users');
            console.error('Failed to fetch users:', error);
            window.location.href = '/login';
        });
    }, []);

    const handleDelete = async (userId) => {
        const token = localStorage.getItem('token');
        if (!window.confirm('Are you sure you want to delete this user?')) return;
    
        try {
          const response = await axios.delete(
            `http://localhost:8000/api/users/${userId}`,
            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          );
    
          // Ukloni obrisanog korisnika iz lokalne liste
          setUsers(prevUsers => prevUsers.filter(user => user.id !== userId));
          setError(null);
        } catch (err) {
          setError('Failed to delete user');
          console.error(err);
        }
      };
 
    return (
        <div className={styles['dashboard-container']}>
            <h2>Admin Dashboard - Registered Users</h2>
            {error && <p className={styles.error}>{error}</p>}
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {users.map(user => (
                        <tr key={user.id}>
                            <td>{user.id}</td>
                            <td>{user.username}</td>
                            <td>{user.email}</td>
                            <td>
                                <button onClick={() => handleDelete(user.id)} className={styles['delete-button']}>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

export default Dashboard;

