import React, { useEffect, useState } from 'react';
import styles from './CategoryList.module.css';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Circles } from 'react-loader-spinner';

const CategoryList = () => {
  const [categories, setCategories] = useState([]);
  const [error, setError] = useState(null);
  const [isAdmin, setIsAdmin] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [categoryToDelete, setCategoryToDelete] = useState(null);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem('token');

    if (token) {
      axios.get('http://127.0.0.1:8000/api/profile', {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      })
        .then(res => setIsAdmin(res.data.is_admin))
        .catch(() => setIsAdmin(false));

      axios.get('http://127.0.0.1:8000/api/question_categories', {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      })
        .then(response => {
          setCategories(response.data);
          setIsLoading(false);
        })
        .catch(() => {
          setError('Greška pri učitavanju kategorija.');
          setIsLoading(false);
        });
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

  if (isLoading) {
    return (
      <div className={styles.loaderContainer}>
        <Circles height="80" width="80" color="#007bff" ariaLabel="loading" />
      </div>
    );
  }

  return (
    <motion.div
      className={styles.categoryListContainer}
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 0.6 }}
    >
      <h2>Kategorije</h2>
      {error && <p className={styles.errorMessage}>{error}</p>}

      <div className={styles.categoryList}>
        {categories.length > 0 ? categories.map(category => (
          <motion.div
            key={category.id}
            className={styles.categoryItem}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.4 }}
          >
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
          </motion.div>
        )) : <h3>Nema dostupnih kategorija.</h3>}
      </div>

      {isAdmin && (
        <motion.div
          className={`${styles.fabButton} ${showDeleteModal ? styles.fabDimmed : ''}`}
          whileHover={{ scale: 1.2 }}
          whileTap={{ scale: 0.95 }}
        >
          <Link to="/categories/create" className={styles.fabLink}>+</Link>
        </motion.div>
      )}

      {showDeleteModal && (
        <motion.div
          className={styles.modalOverlay}
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
        >
          <motion.div
            className={styles.modalContent}
            initial={{ scale: 0.7 }}
            animate={{ scale: 1 }}
            transition={{ duration: 0.3 }}
          >
            <p className={styles.modalText}>Da li ste sigurni da želite da obrišete ovu kategoriju?</p>
            <div className={styles.modalButtons}>
              <button onClick={confirmDelete} className={styles.confirmButton}>Obriši</button>
              <button onClick={() => setShowDeleteModal(false)} className={styles.cancelButton}>Otkaži</button>
            </div>
          </motion.div>
        </motion.div>
      )}
    </motion.div>
  );
};

export default CategoryList;
