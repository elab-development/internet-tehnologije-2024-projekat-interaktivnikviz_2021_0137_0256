import React, { useEffect, useState } from 'react';
import styles from './QuestionList.module.css';
import axios from 'axios';
import { Link } from 'react-router-dom';function QuestionList() {
    const [questions, setQuestions] = useState([]);
    const [error, setError] = useState(null);
    const [isAdmin, setIsAdmin] = useState(false);
const [showDeleteModal, setShowDeleteModal] = useState(false);
const [questionToDelete, setQuestionToDelete] = useState(null);

 
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

const handleDelete = (id) => {
  setQuestionToDelete(id);
  setShowDeleteModal(true);
};

const confirmDelete = () => {
  const token = localStorage.getItem('token');

  axios.delete(`http://127.0.0.1:8000/api/questions/${questionToDelete}/delete`, {
    headers: {
      Authorization: `Bearer ${token}`,
      Accept: 'application/json',
    }
  })
  .then(() => {
    setQuestions(prev => prev.filter(q => q.id !== questionToDelete));
    setShowDeleteModal(false);
    setQuestionToDelete(null);
  })
  .catch(() => {
    alert("Došlo je do greške prilikom brisanja.");
    setShowDeleteModal(false);
    setQuestionToDelete(null);
  });
};


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
                            <button
      className={styles.DeleteButton}
      onClick={() => handleDelete(question.id)}
    >
      Obriši
    </button>
    {showDeleteModal && (
  <div className={styles.modalOverlay}>
    <div className={styles.modalContent}>
      <p>Da li ste sigurni da želite da obrišete ovo pitanje?</p>
      <div className={styles.modalButtons}>
        <button onClick={confirmDelete} className={styles.confirmButton}>Obriši</button>
        <button onClick={() => setShowDeleteModal(false)} className={styles.cancelButton}>Otkaži</button>
      </div>
    </div>
  </div>
)}


 <Link
    to="/questions/create"
    className={`${styles.fabButton} ${showDeleteModal ? styles.fabDimmed : ''}`}
  >+</Link>
  
                          </>
                        )}

                    </div>
                )) : <h3>Pitanja se ucitavaju...</h3>}
            </div>
        </div>
    );
}
 
export default QuestionList;
