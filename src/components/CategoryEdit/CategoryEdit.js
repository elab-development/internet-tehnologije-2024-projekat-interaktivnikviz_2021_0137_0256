import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate, useParams } from 'react-router-dom';
import styles from './CategoryEdit.module.css';

const CategoryEdit = () => {
  const navigate = useNavigate();
  const { id } = useParams();
  const [formData, setFormData] = useState({
    name: '',
    description: ''
  });
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');

  useEffect(() => {
    const token = localStorage.getItem('token');
    axios.get(`http://127.0.0.1:8000/api/question_categories/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    .then(res => {
      setFormData({
        name: res.data.name,
        description: res.data.description || ''
      });
    })
    .catch(() => setError('Greška prilikom učitavanja kategorije.'));
  }, [id]);

  const handleChange = (e) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const token = localStorage.getItem('token');

    if (!formData.name.trim()) {
      setError('Naziv kategorije je obavezan.');
      return;
    }

    axios.put(`http://127.0.0.1:8000/api/question_categories/${id}`, formData, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    })
    .then(() => {
      setMessage('Kategorija uspešno izmenjena.');
      setError('');
      setTimeout(() => navigate('/categories'), 1500);
    })
    .catch(() => {
      setError('Došlo je do greške prilikom izmene.');
    });
  };

  return (
    <div className={styles.container}>
      <h2>Izmeni kategoriju</h2>
      {error && <p className={styles.error}>{error}</p>}
      {message && <p className={styles.success}>{message}</p>}
      <form onSubmit={handleSubmit} className={styles.form}>
        <label>Naziv:</label>
        <input
          type="text"
          name="name"
          value={formData.name}
          onChange={handleChange}
        />

        <label>Opis:</label>
        <textarea
          name="description"
          value={formData.description}
          onChange={handleChange}
          rows={4}
        />

        <button type="submit" className={styles.submitButton}>Sačuvaj izmene</button>
      </form>
    </div>
  );
};

export default CategoryEdit;
