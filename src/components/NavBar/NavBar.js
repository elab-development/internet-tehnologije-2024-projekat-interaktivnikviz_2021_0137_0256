import React, { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import styles from './NavBar.module.css'; // CSS module for scoped styles
 

    function NavBar({ authChanged }) {
        const [isAdmin, setIsAdmin] = useState(false);
        const navigate = useNavigate();
        const [isLoggedIn, setIsLoggedIn] = useState(!!localStorage.getItem('token'));

        
        useEffect(() => {
            const token = localStorage.getItem('token');
            setIsLoggedIn(!!token); // Update login status

            if (token) {
  axios.get('http://127.0.0.1:8000/api/profile', {
    headers: {
      Authorization: `Bearer ${token}`,
      'Accept': 'application/json'
    }
  })
  .then(res => {
    const user = res.data;
    setIsAdmin(user.role === 'admin'); // postavi true samo ako je admin
  })
  .catch(() => setIsAdmin(false));
} else {
  setIsAdmin(false);
}
        }, [authChanged]); // dodato u dependency listu
    

    const handleLogout = () => {
        localStorage.removeItem('token');
        setIsAdmin(false); // Resetujemo stanje admina
        navigate('/login');
        window.location.reload(); // Reload stranice da bi se osvežili podaci
    };
 
   return (
  <nav className={styles.navbar}>
    <ul className={styles.navLinks}>
        <li>
            <Link to="/questions">Questions</Link>
          </li>
      {isLoggedIn && (
        <>
          <li>
            <Link to="/leaderboards">Leaderboard</Link>
          </li>

          {isAdmin && (
            <li>
              <Link to="/dashboard">Admin Dashboard</Link>
            </li>
          )}
        </>
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

