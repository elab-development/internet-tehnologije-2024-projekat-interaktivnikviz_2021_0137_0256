import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import styles from './CategoryCreate.module.css';

const CategoryCreate = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    name: '',
    description: ''
  });
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');

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

    axios.post('http://127.0.0.1:8000/api/question_categories', formData, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    })
    .then(res => {
      setMessage('Kategorija uspešno dodata.');
      setError('');
      setTimeout(() => navigate('/questions'), 1500);
    })
    .catch(() => {
      setError('Došlo je do greške prilikom dodavanja.');
    });
  };

  return (
    <div className={styles.container}>
      <h2>Dodaj novu kategoriju</h2>
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

        <label>Opis (opciono):</label>
        <textarea
          name="description"
          value={formData.description}
          onChange={handleChange}
          rows={4}
        />

        <button type="submit" className={styles.saveButton}>Dodaj</button>
      </form>
    </div>
  );
};

export default CategoryCreate;
