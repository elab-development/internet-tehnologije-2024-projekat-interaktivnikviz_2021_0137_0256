import React, { useEffect, useState } from 'react';
import styles from './CategoryList.module.css';
import axios from 'axios';
import { Link } from 'react-router-dom';

const CategoryList = () => {
  const [categories, setCategories] = useState([]);
  const [error, setError] = useState(null);
  const [isAdmin, setIsAdmin] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [categoryToDelete, setCategoryToDelete] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem('token');

    if (token) {
      axios.get('http://127.0.0.1:8000/api/profile', {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      })
        .then(res => {
          setIsAdmin(res.data.is_admin);
        })
        .catch(() => setIsAdmin(false));

      axios.get('http://127.0.0.1:8000/api/question_categories', {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      })
        .then(response => setCategories(response.data))
        .catch(() => setError('Greška pri učitavanju kategorija.'));
    }
  }, []);

  const handleDelete = (id) => {
    setCategoryToDelete(id);
    setShowDeleteModal(true);
  };

  const confirmDelete = () => {
    const token = localStorage.getItem('token');

    axios.delete(`http://127.0.0.1:8000/api/question_categories/${categoryToDelete}/delete`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      }
    })
    .then(() => {
      setCategories(prev => prev.filter(c => c.id !== categoryToDelete));
      setShowDeleteModal(false);
      setCategoryToDelete(null);
    })
    .catch(() => {
      alert("Došlo je do greške prilikom brisanja.");
      setShowDeleteModal(false);
      setCategoryToDelete(null);
    });
  };

  return (
    <div className={styles.categoryListContainer}>
      <h2>Kategorije</h2>
      {error && <p className={styles.errorMessage}>{error}</p>}

      <div className={styles.categoryList}>
        {categories.length > 0 ? categories.map(category => (
          <div key={category.id} className={styles.categoryItem}>
            <h3>{category.name}</h3>
            <p>{category.description}</p>

            {isAdmin && (
              <div className={styles.buttonGroup}>
                <Link to={`/categories/edit/${category.id}`} className={styles.Button}>Izmeni</Link>
                <button
                  className={styles.DeleteButton}
                  onClick={() => handleDelete(category.id)}
                >
                  Obriši
                </button>
              </div>
            )}
          </div>
        )) : <h3>Učitavanje kategorija...</h3>}
      </div>

      {isAdmin && (
        <Link
          to="/categories/create"
          className={`${styles.fabButton} ${showDeleteModal ? styles.fabDimmed : ''}`}
        >
          +
        </Link>
      )}

      {showDeleteModal && (
        <div className={styles.modalOverlay}>
          <div className={styles.modalContent}>
            <p>Da li ste sigurni da želite da obrišete ovu kategoriju?</p>
            <div className={styles.modalButtons}>
              <button onClick={confirmDelete} className={styles.confirmButton}>Obriši</button>
              <button onClick={() => setShowDeleteModal(false)} className={styles.cancelButton}>Otkaži</button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default CategoryList;
