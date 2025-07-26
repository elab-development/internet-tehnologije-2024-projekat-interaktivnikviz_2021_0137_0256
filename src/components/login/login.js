import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import styles from './login.module.css';

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/admin/login', { email, password }, {
        headers: { Accept: 'application/json' }
      });

      localStorage.setItem('token', response.data.access_token);
      window.location.href = '/dashboard';
    } catch {
      try {
        const userResponse = await axios.post('http://127.0.0.1:8000/api/login', { email, password }, {
          headers: { Accept: 'application/json' }
        });

        localStorage.setItem('token', userResponse.data.access_token);
        window.location.href = '/leaderboards';
      } catch (err) {
        console.error('Login failed:', err);
        setError('Neuspešno logovanje. Proverite email i lozinku.');
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className={styles.container}>
      <h2>Prijavi se</h2>
      <form onSubmit={handleLogin} className={styles.form}>
        <div className={styles.inputGroup}>
          <label>Email:</label>
          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
        </div>

        <div className={styles.inputGroup}>
          <label>Lozinka:</label>
          <input
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </div>

        <button type="submit" disabled={loading}>
          {loading ? 'Prijavljivanje...' : 'Prijavi se'}
        </button>

        {error && <p className={styles.error}>{error}</p>}
      </form>
    </div>
  );
};

export default Login;
