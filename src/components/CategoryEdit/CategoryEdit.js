import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate, useParams } from 'react-router-dom';
import styles from './CategoryEdit.module.css';
import { motion } from 'framer-motion';
import { Circles } from 'react-loader-spinner';

const CategoryEdit = () => {
  const navigate = useNavigate();
  const { id } = useParams();
  const [formData, setFormData] = useState({ name: '', description: '' });
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem('token');
    axios.get(`http://127.0.0.1:8000/api/question_categories/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
      setFormData({
        name: res.data.name,
        description: res.data.description || ''
      });
      setLoading(false);
    })
    .catch(() => {
      setError('Greška prilikom učitavanja kategorije.');
      setLoading(false);
    });
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

  if (loading) {
    return (
      <div className={styles.loaderContainer}>
        <Circles height="80" width="80" color="#007bff" ariaLabel="loading" />
      </div>
    );
  }

  return (
    <motion.div
      className={styles.container}
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 0.5 }}
    >
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

        <button type="submit" className={styles.saveButton}>Sačuvaj izmene</button>
      </form>
    </motion.div>
  );
};

export default CategoryEdit;
