import React, { useEffect, useState } from 'react';
import styles from './QuestionList.module.css';
import axios from 'axios';
import { Link } from 'react-router-dom';function QuestionList() {
    const [questions, setQuestions] = useState([]);
    const [error, setError] = useState(null);
    const [isAdmin, setIsAdmin] = useState(false);

 
 useEffect(() => {
  const token = localStorage.getItem('token');

  axios.get('http://127.0.0.1:8000/api/questions', {
    headers: {
      Authorization: `Bearer ${token}`,
       Accept: 'application/json',
    },
  })
    .then(response => {
      setQuestions(response.data.data);
    })
    .catch(error => {
      setError('Failed to fetch questions');
    });

  if (token) {
    axios.get('http://127.0.0.1:8000/api/profile', {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })
      .then(res => {
        const user = res.data;
        setIsAdmin(user.is_admin);
      })
      .catch(() => setIsAdmin(false));
  }
}, []);

    return (
        <div className={styles.questionListContainer}>
            <h2>Questions</h2>
            {error && <p className={styles.errorMessage}>{error}</p>}
            <div className={styles.questionList}>
                {questions.length > 0 ? questions.map(question => (
                    <div key={question.id} className={styles.questionItem}>
                        <h3>{question.question}</h3>
                        <p><strong>Category:</strong> {question.category_name}</p>
                     
                        
                        {isAdmin && (
                          <>
                            <Link to={`/questions/${question.id}`} className={styles.Button}>
                            Read More
                            </Link>
                            <Link to={`/questions/edit/${question.id}`} className={styles.Button}>
                              Edit
                            </Link>
                          </>
                        )}

                    </div>
                )) : <h3>Pitanja se ucitavaju...</h3>}
            </div>
        </div>
    );
}
 
export default QuestionList;
