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

    // Dohvatanje leaderboarda
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

    // Provera da li je admin
    axios.get('http://127.0.0.1:8000/api/admin/profile', {
          headers: {
              Authorization: `Bearer ${token}`,
          }
  })
    .then(() => setIsAdmin(true))
    .catch(() => setIsAdmin(false));
  }, []);
  

  if (loading) return <p>Učitavanje...</p>;
  if (error) return <p>{error}</p>;

  // Ova funkcija će se pozvati kada korisnik klikne na dugme za eksportovanje
  const handleExport = () => {
    const token = localStorage.getItem('token');
    axios.get('http://127.0.0.1:8000/api/leaderboards-export', {
      headers: {
        Authorization: `Bearer ${token}`,
        'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
      },
      responseType: 'blob' // Ovaj deo je važan za preuzimanje datoteke jer nam govori da očekujemo binarni odgovor
    })
    .then(response => {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'leaderboard.xlsx');
      document.body.appendChild(link);
      link.click();
    })
    .catch(err => {
      console.error('Greška prilikom eksportovanja:', err);
      alert('Nešto nije u redu prilikom eksportovanja.');
    });
  };  

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
      {isAdmin && (
        <button onClick={handleExport} className={styles.exportButton}>
            Exportuj u Excel
        </button>
      )}

    </div>
  );
};

export default Leaderboard;
