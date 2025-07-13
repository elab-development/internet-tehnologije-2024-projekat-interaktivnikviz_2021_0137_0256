import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import styles from './QuestionCreate.module.css';

const QuestionCreate = () => {
  const navigate = useNavigate();
  const [categories, setCategories] = useState([]);
  const [formData, setFormData] = useState({
    category_id: '',
    question: '',
    options: ['', '', '', ''],
    correctAnswerIndex: 0,
    points: '',
  });
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');

  useEffect(() => {
    const token = localStorage.getItem('token');
    axios.get('http://127.0.0.1:8000/api/question_categories', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
    .then(res => setCategories(res.data))
    .catch(() => setError('Greška pri učitavanju kategorija.'));
  }, []);

  const handleOptionChange = (index, value) => {
    const updatedOptions = [...formData.options];
    updatedOptions[index] = value;
    setFormData({ ...formData, options: updatedOptions });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    const { category_id, question, options, points, correctAnswerIndex } = formData;

    if (!category_id || !question || !points || options.some(opt => opt.trim() === '')) {
      setError('Sva polja i sve opcije moraju biti popunjene.');
      return;
    }

    const token = localStorage.getItem('token');
    const payload = {
      category_id,
      question,
      options: JSON.stringify(options),
      answer: options[correctAnswerIndex],
      points,
    };

    axios.post('http://127.0.0.1:8000/api/questions', payload, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    })
      .then(() => {
        setMessage('Pitanje uspešno kreirano.');
        setError('');
        setTimeout(() => navigate('/questions'), 1500);
      })
      .catch(() => setError('Greška prilikom kreiranja pitanja.'));
  };

  return (
    <div className={styles.container}>
      <h2>Kreiraj Pitanje</h2>
      {error && <p className={styles.error}>{error}</p>}
      {message && <p className={styles.success}>{message}</p>}
      <form onSubmit={handleSubmit} className={styles.form}>
        <label>Kategorija:</label>
        <select
          name="category_id"
          value={formData.category_id}
          onChange={(e) => setFormData({ ...formData, category_id: e.target.value })}
        >
          <option value="">Izaberi kategoriju</option>
          {categories.map(cat => (
            <option key={cat.id} value={cat.id}>{cat.name}</option>
          ))}
        </select>

        <label>Pitanje:</label>
        <input
          type="text"
          name="question"
          value={formData.question}
          onChange={(e) => setFormData({ ...formData, question: e.target.value })}
        />

        <div className={styles.optionHeader}>
          <label className={styles.optionLabel}>Odgovor</label>
          <label className={styles.answerLabel}>Tačan odgovor</label>
        </div>

        {formData.options.map((option, index) => (
          <div key={index} className={styles.optionRow}>
            <input
              type="text"
              className={styles.optionInput}
              value={option}
              onChange={(e) => handleOptionChange(index, e.target.value)}
            />
            <input
              type="radio"
              name="correctAnswer"
              className={styles.optionRadio}
              checked={formData.correctAnswerIndex === index}
              onChange={() => setFormData({ ...formData, correctAnswerIndex: index })}
            />
          </div>
        ))}

        <label>Broj poena:</label>
        <input
          type="number"
          name="points"
          value={formData.points}
          onChange={(e) => setFormData({ ...formData, points: e.target.value })}
        />

        <button type="submit" className={styles.submitButton}>Kreiraj</button>
      </form>
    </div>
  );
};

export default QuestionCreate;
