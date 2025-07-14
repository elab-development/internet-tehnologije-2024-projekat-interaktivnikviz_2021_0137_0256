import React, { useEffect, useState } from 'react';
import styles from './QuestionList.module.css';
import axios from 'axios';
import { Link } from 'react-router-dom';function QuestionList() {
    const [questions, setQuestions] = useState([]);
    const [error, setError] = useState(null);
    const [isAdmin, setIsAdmin] = useState(false);
const [showDeleteModal, setShowDeleteModal] = useState(false);
const [questionToDelete, setQuestionToDelete] = useState(null);
const [filters, setFilters] = useState({
      category_id: '',
      min_points: '',
      max_points: '',
  });
const [categories, setCategories] = useState([]);

useEffect(() => {
  const token = localStorage.getItem('token');
  axios.get('http://127.0.0.1:8000/api/question_categories', {
    headers: {
      Authorization: `Bearer ${token}`,
      Accept: 'application/json'
    }
  })
  .then(res => setCategories(res.data))
  .catch(() => setCategories([]));
}, []);

 
  useEffect(() => {
    // Učitaj pitanja sa filterima
    const token = localStorage.getItem('token');
    const params = {};
  
    if (filters.category_id) params.category_id = filters.category_id;
    if (filters.min_points) params.min_points = filters.min_points;
    if (filters.max_points) params.max_points = filters.max_points;
  
    axios.get('http://127.0.0.1:8000/api/questions', {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
      params,   // <=== OVDE dodaj params
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
  }, [filters]);

const handleFilterChange = (e) => {
  const { name, value } = e.target;
  setFilters(prev => ({ ...prev, [name]: value }));
};

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
            <div>
              <label>
                Kategorija:
                <select name="category_id" value={filters.category_id} onChange={handleFilterChange}>
                  <option value="">Sve</option>
                  {categories.map(cat => (
                    <option key={cat.id} value={cat.id}>{cat.name}</option>
                  ))}
                </select>
              </label>

              <label>
                Min poena:
                <input
                  type="number"
                  name="min_points"
                  value={filters.min_points}
                  onChange={handleFilterChange}
                  min="0"
                />
              </label>

              <label>
                Max poena:
                <input
                  type="number"
                  name="max_points"
                  value={filters.max_points}
                  onChange={handleFilterChange}
                  min="0"
                />
              </label>
            </div>
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
