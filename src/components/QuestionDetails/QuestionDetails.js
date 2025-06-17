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
                setQuestion(response.data.question);
            })
            .catch(error => {
                setError('Failed to fetch question details');
            });
    }, [id]);
 
    return (
        <div className={styles.questionDetailsContainer}>
            {error && <p className={styles.errorMessage}>{error}</p>}
            {question ? (
                <div className={styles.questionDetails}>
                    <h2>{question.question}</h2>
                    <p><strong>Category:</strong> {question.category.name}</p>
                    <p><strong>Points:</strong> {question.points}</p>
                    <p><strong>Options:</strong></p>
                    <ul>
                        {question.options && Object.entries(question.options).map(([key, value]) => (
                            <li key={key}><strong>{key}:</strong> {value}</li>
                        ))}
                    </ul>
                    <p><strong>Answer:</strong> {question.answer}</p>

                </div>
            ) : <p>Loading...</p>}
        </div>
    );
}
 
export default QuestionDetails;
