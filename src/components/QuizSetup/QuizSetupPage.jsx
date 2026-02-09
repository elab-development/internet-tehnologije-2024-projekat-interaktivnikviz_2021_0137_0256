import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import styles from './QuizSetupPage.module.css';
import { Circles } from 'react-loader-spinner';
import { motion } from 'framer-motion';

function QuizSetupPage() {
  const [type, setType] = useState('mix'); // mix | category
  const [categories, setCategories] = useState([]);
  const [selectedCategory, setSelectedCategory] = useState('');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [token, setToken] = useState(localStorage.getItem('token'));

  const navigate = useNavigate();

  useEffect(() => {
    if (!token) {
      setError('Da biste videli kategorije, potrebno je da se ulogujete.');
      setLoading(false);
      return;
    }

    axios.get('http://127.0.0.1:8000/api/question_categories', {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })
      .then(res => {
        // Laravel API vraća {data: [...]}, neki možda direktno [...]
        setCategories(res.data.data ?? res.data);
        setLoading(false);
      })
      .catch(() => {
        setError('Greška pri učitavanju kategorija.');
        setLoading(false);
      });
  }, [token]);

  const startQuiz = () => {
    if (type === 'category' && !selectedCategory) {
      setError('Morate izabrati kategoriju.');
      return;
    }

    if (type === 'mix') {
      navigate('/quiz/play?type=mix');
    } else {
      navigate(`/quiz/play?type=category&category_id=${selectedCategory}`);
    }
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
      className={styles.quizContainer}
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 0.6 }}
    >
      <h3>Izaberite tip kviza</h3>

      {error && <div className={styles.warning}>{error}</div>}

      <div className={styles.options}>
        <button
          className={`${styles.optionButton} ${type === 'mix' ? styles.selected : ''}`}
          onClick={() => setType('mix')}
        >
          🎲 Mix (sve kategorije)
        </button>

        <button
          className={`${styles.optionButton} ${type === 'category' ? styles.selected : ''}`}
          onClick={() => setType('category')}
        >
          📚 Po kategoriji
        </button>
      </div>

      {type === 'category' && (
        <select
          className={styles.select}
          value={selectedCategory}
          onChange={(e) => setSelectedCategory(e.target.value)}
        >
          <option value="">-- Izaberi kategoriju --</option>
          {categories.map(cat => (
            <option key={cat.id} value={cat.id}>
              {cat.name}
            </option>
          ))}
        </select>
      )}

      <button className={styles.nextButton} onClick={startQuiz}>
        Započni kviz
      </button>
    </motion.div>
  );
}

export default QuizSetupPage;
