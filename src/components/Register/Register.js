import React, { useState } from 'react';
import axios from 'axios';
import styles from './Register.module.css';

const Register = () => {
  const [form, setForm] = useState({
    username: '',
    email: '',
    password: ''
  });
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value }); ///...form uzima postavljene vrednosti, a [e.target.name] uzima ime polja koje se menja
    setError(null);
    setSuccess(null);
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    if (form.password.length < 6) {
        setError('Lozinka mora imati najmanje 6 karaktera');
        setSuccess(null);
        return;
      }

    axios.post('http://127.0.0.1:8000/api/register', form)
      .then(res => {
        setSuccess('Uspešno registrovan korisnik!');
        setForm({ username: '', email: '', password: '' });
      })
      .catch(err => {
        setSuccess(null);  // resetuj poruku uspeha ako je došlo do greške
        if (err.response && err.response.data && err.response.data.errors) {
          const firstError = Object.values(err.response.data.errors)[0][0];
          setError(firstError);
        } else {
          setError('Došlo je do greške. Pokušaj ponovo.');
        }
      });
  };

  return (
    <div className={styles.registerContainer}>
      <h2>Registracija</h2>
      {error && <p className={styles.error}>{error}</p>}
      {success && <p className={styles.success}>{success}</p>}

      <form onSubmit={handleSubmit} className={styles.registerForm}>
        <input
          type="text"
          name="username"
          placeholder="Korisničko ime"
          value={form.username}
          onChange={handleChange}
          required
        />

        <input
          type="email"
          name="email"
          placeholder="Email adresa"
          value={form.email}
          onChange={handleChange}
          required
        />

        <input
          type="password"
          name="password"
          placeholder="Lozinka"
          value={form.password}
          onChange={handleChange}
          required
        />

        <button type="submit">Registruj se</button>
      </form>
    </div>
  );
};

export default Register;
