import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';
import styles from './QuestionEdit.module.css';

function QuestionEdit() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [questionData, setQuestionData] = useState({
    category_id: '',
    question: '',
    answer: '',
    points: '',
  });
  const [options, setOptions] = useState(['', '', '', '']);
  const [categories, setCategories] = useState([]);
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');

  useEffect(() => {
    const token = localStorage.getItem('token');

    axios.get(`http://127.0.0.1:8000/api/questions/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })
    .then(res => {
      const data = res.data;
      const questionCategoryName = data.category_name;

      axios.get('http://127.0.0.1:8000/api/question_categories', {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then(resCat => {
        const categoriesList = resCat.data;
        setCategories(categoriesList);

        const matchedCategory = categoriesList.find(cat => cat.name === questionCategoryName);

        setQuestionData({
          category_id: matchedCategory ? matchedCategory.id : '',
          question: data.question,
          answer: data.answer,
          points: data.points,
        });
        setOptions(data.options && data.options.length === 4 ? data.options : ['', '', '', '']);
      });
    })
    .catch(() => setError('Failed to fetch question.'));
  }, [id]);

  const handleChange = (e) => {
    setQuestionData({ ...questionData, [e.target.name]: e.target.value });
  };

  const handleOptionChange = (index, value) => {
    const updated = [...options];
    updated[index] = value;
    setOptions(updated);

    // Ako trenutni odgovor odgovara staroj vrednosti, ažuriraj na novu
    if (questionData.answer === options[index]) {
      setQuestionData(prev => ({ ...prev, answer: value }));
    }
  };

  const handleSelectAnswer = (index) => {
    setQuestionData({ ...questionData, answer: options[index] });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const token = localStorage.getItem('token');

    if (options.some(opt => opt.trim() === '')) {
      setError('Sva 4 odgovora moraju biti popunjena.');
      return;
    }

    if (!options.includes(questionData.answer)) {
      setError('Tačan odgovor mora biti jedan od ponuđenih.');
      return;
    }

    axios.put(`http://127.0.0.1:8000/api/questions/${id}`, {
      ...questionData,
      options: JSON.stringify(options),
    }, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    })
    .then(() => {
      setMessage('Pitanje uspešno izmenjeno.');
      setError('');
      setTimeout(() => navigate('/questions'), 1500);
    })
    .catch(err => {
      const msg = err.response?.data?.message || 'Greška pri izmeni pitanja.';
      setError(msg);
    });
  };

  return (
    <div className={styles.container}>
      <h2>Izmeni pitanje</h2>
      {error && <p className={styles.error}>{error}</p>}
      {message && <p className={styles.success}>{message}</p>}

      <form onSubmit={handleSubmit} className={styles.form}>
        <label>Kategorija:</label>
        <select name="category_id" value={questionData.category_id} onChange={handleChange}>
          <option value="">-- Izaberi --</option>
          {categories.map(cat => (
            <option key={cat.id} value={cat.id}>{cat.name}</option>
          ))}
        </select>

        <label>Pitanje:</label>
        <input
          type="text"
          name="question"
          value={questionData.question}
          onChange={handleChange}
        />
<div className={styles.optionHeader}>
  <label className={styles.optionLabel}>Opcije:</label>
  <label className={styles.answerLabel}>Tačan odgovor:</label>
</div>
       {options.map((opt, idx) => (
  <div key={idx} className={styles.optionRow}>
    <input
      type="text"
      className={styles.optionInput}
      value={opt}
      onChange={(e) => handleOptionChange(idx, e.target.value)}
    />
    <input
      type="radio"
      name="correctAnswer"
      checked={questionData.answer === opt}
      onChange={() => setQuestionData(prev => ({ ...prev, answer: opt }))}
      className={styles.optionRadio}
    />
  </div>
))}

        <label>Poeni:</label>
        <input
          type="number"
          name="points"
          value={questionData.points}
          onChange={handleChange}
        />

        <button type="submit" className={styles.saveButton}>Sačuvaj izmene</button>
      </form>
    </div>
  );
}

export default QuestionEdit;
