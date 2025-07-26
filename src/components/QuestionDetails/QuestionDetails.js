import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams } from 'react-router-dom';
import styles from './QuestionDetails.module.css';

function QuestionDetails() {
  const { id } = useParams(); 
  const [question, setQuestion] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem('token');
    axios.get(`http://127.0.0.1:8000/api/questions/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    .then(response => {
      setQuestion(response.data);
    })
    .catch(() => {
      setError('Greška pri učitavanju podataka o pitanju.');
    });
  }, [id]);

  const getOptionsArray = () => {
    if (!question?.options) return [];
    if (Array.isArray(question.options)) return question.options;
    try {
      const parsed = JSON.parse(question.options);
      return Array.isArray(parsed) ? parsed : [];
    } catch {
      return [];
    }
  };

  return (
    <div className={styles.container}>
      {error && <div className={styles.error}>{error}</div>}

      {question ? (
        <>
          <h2 className={styles.title}>{question.question}</h2>
          <p className={styles.meta}>
            Kategorija: <strong>{question.category_name}</strong> | Poeni: <strong>{question.points}</strong>
          </p>

          <div className={styles.section}>
            <h4>Opcije:</h4>
            <ul className={styles.options}>
              {getOptionsArray().map((option, index) => (
                <li key={index}>{option}</li>
              ))}
            </ul>
          </div>

          <div className={styles.section}>
            <h4>Tačan odgovor:</h4>
            <p className={styles.answer}>{question.answer}</p>
          </div>

          <button onClick={() => window.history.back()} className={styles.backButton}>
            ← Nazad
          </button>
        </>
      ) : (
        <p className={styles.loading}>Učitavanje...</p>
      )}
    </div>
  );
}

export default QuestionDetails;
