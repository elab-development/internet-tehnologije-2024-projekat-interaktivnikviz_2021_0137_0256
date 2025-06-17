import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './Dashboard.module.css';  // Uvoz CSS modula
 
function Dashboard() {
    const [users, setUsers] = useState([]);
    const [error, setError] = useState(null);
 
    useEffect(() => {
        const token = localStorage.getItem('token');
 
        axios.get('http://127.0.0.1:8000/api/admin/users', {
            headers: {
                Authorization: `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            setUsers(response.data);
        })
        .catch(() => {
            setError('Failed to fetch users');
            window.location.href = '/login';
        });
    }, []);
 
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
                    </tr>
                </thead>
                <tbody>
                    {users.map(user => (
                        <tr key={user.id}>
                            <td>{user.id}</td>
                            <td>{user.username}</td>
                            <td>{user.email}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
 
export default Dashboard;

