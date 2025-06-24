import React, { useEffect, useState } from 'react';
import styles from './QuestionList.module.css';
import axios from 'axios';
import { Link } from 'react-router-dom';function QuestionList() {
    const [questions, setQuestions] = useState([]);
    const [error, setError] = useState(null);
 
 
    useEffect(() => {
        const token = localStorage.getItem('token');
        axios.get(`http://127.0.0.1:8000/api/questions`, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
            
            .then(response => {
                console.log(response.data.data);
                setQuestions(response.data.data);
                console.log(questions.options);
               
            })
            .catch(error => {
                setError('Failed to fetch questions');
            });
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
                     
                        
                        <Link to={`/questions/${question.id}`} className={styles.readMoreButton}>Read More</Link>
                    </div>
                )) : <p>No questions available</p>}
            </div>
        </div>
    );
}
 
export default QuestionList;
