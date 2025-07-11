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
          console.log("QUESTION RESPONSE:", response.data);
          setQuestion(response.data);
        })
            .catch(error => {
                setError('Failed to fetch question details');
            });
    }, [id]);

    const getOptionsArray = () => {
      if (!question?.options) {
        console.log("No options found");
        return [];
      }
    
      if (Array.isArray(question.options)) {
        console.log("Options is already array:", question.options);
        return question.options;
      }
    
      try {
        const parsed = JSON.parse(question.options);
        console.log("Parsed options from JSON:", parsed);
        return Array.isArray(parsed) ? parsed : [];
      } catch (e) {
        console.error("Error parsing options:", e);
        return [];
      }
    };
 
    return (
      <div className={styles.questionDetailsContainer}>
        {error && <div className={styles.errorBanner}>{error}</div>}
  
        {question ? (
          <>
            <h2 className={styles.questionTitle}>{question.question}</h2>
  
            <p className={styles.questionMeta}>
              Kategorija: {question.category_name} | Poeni: {question.points}
            </p>
  
            <p className={styles.questionDescription}>Opcije:</p>
            <ul className={styles.answerList}>
              {getOptionsArray().map((option, index) => (
            <li key={index}>{option}</li>
            ))}
            </ul>


  
            <p className={styles.questionDescription}>
              <strong>Odgovor:</strong> {question.answer}
            </p>
  
            <button onClick={() => window.history.back()} className={styles.backButton}>
              ← Back
            </button>
          </>
        ) : (
          <p>Loading...</p>
        )}
      </div>
    );
  }
  
  export default QuestionDetails;