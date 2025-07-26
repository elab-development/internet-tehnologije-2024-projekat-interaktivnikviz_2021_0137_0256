import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './Leaderboard.module.css';

const Leaderboard = () => {
  const [leaders, setLeaders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [isAdmin, setIsAdmin] = useState(false);

  useEffect(() => {
    const token = localStorage.getItem('token');

    // Provera admina
    axios.get('http://127.0.0.1:8000/api/profile', {
      headers: { Authorization: `Bearer ${token}` }
    })
    .then(response => setIsAdmin(response.data.is_admin))
    .catch(() => setIsAdmin(false));

    // Dohvatanje leaderboarda
    axios.get('http://127.0.0.1:8000/api/leaderboards', {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    })
    .then(response => {
      setLeaders(response.data.data);
      setLoading(false);
    })
    .catch(() => {
      setError('Greška prilikom učitavanja leaderboarda');
      setLoading(false);
    });
  }, []);

  const handleExport = () => {
    const token = localStorage.getItem('token');
    axios.get('http://127.0.0.1:8000/api/leaderboards-export', {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
      },
      responseType: 'blob'
    })
    .then(response => {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'leaderboard.xlsx');
      document.body.appendChild(link);
      link.click();
      link.remove();
    })
    .catch(() => alert('Nešto nije u redu prilikom eksportovanja.'));
  };

  if (loading) {
    return (
      <div className={styles.loaderContainer}>
        <div className={styles.loader}></div>
      </div>
    );
  }
  if (error) return <p className={styles.error}>{error}</p>;

  return (
    <div className={styles.leaderboard}>
      <h2>Leaderboard</h2>
      <ul>
        {leaders.map((entry, index) => {
          const rankClass =
            index === 0 ? styles.gold :
            index === 1 ? styles.silver :
            index === 2 ? styles.bronze : '';

          const avatarName = entry.user?.avatar && entry.user.avatar.includes('.') 
            ? entry.user.avatar 
            : 'default.png';

          return (
            <li key={entry.id} className={`${styles.leaderItem} ${rankClass}`}>
              <span className={styles.rank}>{index + 1}.</span>
              <img
                src={`/avatars/${avatarName}`}
                alt="avatar"
                className={styles.leaderAvatar}
              />
              <span className={styles.username}>
                {entry.user?.username || 'Nepoznat'} - {entry.points} poena
              </span>
            </li>
          );
        })}
      </ul>

      {isAdmin && (
        <button onClick={handleExport} className={styles.exportButton}>
          Exportuj u Excel
        </button>
      )}
    </div>
  );
};

export default Leaderboard;
