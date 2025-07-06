import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './Leaderboard.module.css';

const Leaderboard = () => {
  const [leaders, setLeaders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem('token');
    axios.get('http://127.0.0.1:8000/api/leaderboards', {
            headers: {
                Authorization: `Bearer ${token}`,
                'Accept': 'application/json'
            }
        }
    )
      .then(response => {
        setLeaders(response.data.data);
        console.log('Fetched leaders:', response.data.data);
        setLoading(false);
      })
      .catch(error => {
        setError('Greška prilikom učitavanja leaderboarda');
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Učitavanje...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div className={styles.leaderboard}>
      <h2>Leaderboard</h2>
      <ul>
        {leaders.map((entry, index) => (
          <li key={entry.user_id}>
            {index + 1}. {entry.user?.username || 'Nepoznat'} - {entry.points} poena
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Leaderboard;
