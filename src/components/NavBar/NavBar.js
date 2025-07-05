import React, { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import styles from './NavBar.module.css'; // CSS module for scoped styles
 
function NavBar() {
    const [isAdmin, setIsAdmin] = useState(false);  // State za proveru admina
    const navigate = useNavigate();
 
    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            axios.get('http://127.0.0.1:8000/api/admin/profile', {
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                setIsAdmin(true);  
            })
            .catch(() => {
                setIsAdmin(false);
            });
        }
    }, []);
 
    const handleLogout = () => {
        localStorage.removeItem('token');
        navigate('/login'); 
    };
 
    return (
        <nav className={styles.navbar}>
            <ul className={styles.navLinks}>
                <li>
                    <Link to="/questions">Questions</Link>
                </li>
                
                {isAdmin && (
                    <li>
                        <Link to="/dashboard">Admin Dashboard</Link>
                    </li>
                )}
 
                <li>
                    <button onClick={handleLogout} className={styles.logoutButton}>
                        Logout
                    </button>
                </li>
            </ul>
        </nav>
    );
}
 
export default NavBar;

