import React, { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import styles from './NavBar.module.css'; // CSS module for scoped styles

function NavBar({ authChanged }) {
  const [isAdmin, setIsAdmin] = useState(false);
  const [isLoggedIn, setIsLoggedIn] = useState(!!localStorage.getItem('token'));
  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem('token');
    setIsLoggedIn(!!token);

    if (token) {
      axios.get('http://127.0.0.1:8000/api/profile', {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      })
      .then(res => {
        const user = res.data;
        setIsAdmin(user.is_admin);
      })
      .catch(() => setIsAdmin(false));
    } else {
      setIsAdmin(false);
    }
  }, [authChanged]);

  const handleLogout = () => {
    localStorage.removeItem('token');
    setIsAdmin(false);
    navigate('/login');
    window.location.reload(); // Osvežavanje stranice nakon logouta
  };

  return (
    <nav className={styles.navbar}>
      <ul className={styles.navLinks}>
        {isLoggedIn && (
          <>
            <li><Link to="/leaderboards">Leaderboard</Link></li>
            <li><Link to="/profile">Profile</Link></li>

            {isAdmin && (
              <>
                <li><Link to="/dashboard">Admin Dashboard</Link></li>
                <li><Link to="/questions">Questions</Link></li>
                <li><Link to="/categories">Categories</Link></li>
              </>
            )}
          </>
        )}

        {!isLoggedIn && (
          <li><Link to="/register">Register</Link></li>
        )}

        <li>
          {isLoggedIn ? (
            <button onClick={handleLogout} className={styles.logoutButton}>
              Logout
            </button>
          ) : (
            <Link to="/login" className={styles.logoutButton}>
              Login
            </Link>
          )}
        </li>
      </ul>
    </nav>
  );
}

export default NavBar;
