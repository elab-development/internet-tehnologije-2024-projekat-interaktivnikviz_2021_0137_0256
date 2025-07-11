import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';
import './QuestionEdit.module.css'; 

function QuestionEdit() {
  const { id } = useParams(); // ID iz URL-a
  const navigate = useNavigate();
  const [questionData, setQuestionData] = useState({
    category_id: '',
    question: '',
    options: '',
    answer: '',
    points: '',
  });
  const [categories, setCategories] = useState([]);
  const [error, setError] = useState('');
  const [message, setMessage] = useState('');

  useEffect(() => {
    const token = localStorage.getItem('token');
  
    // Učitaj pitanje
    axios.get(`http://127.0.0.1:8000/api/questions/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })
    .then(res => {
      const data = res.data;
      // Ovo je ime kategorije iz pitanja
      const questionCategoryName = data.category_name; 
  
      // Učitaj kategorije i onda postavi category_id koji odgovara tom imenu
      axios.get('http://127.0.0.1:8000/api/question_categories', {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then(resCat => {
        const categoriesList = resCat.data;
        setCategories(categoriesList);
  
        // Nađi kategoriju po imenu
        const matchedCategory = categoriesList.find(cat => cat.name === questionCategoryName);
  
        setQuestionData({
          category_id: matchedCategory ? matchedCategory.id : '',
          question: data.question,
          options: JSON.stringify(data.options, null, 2),
          answer: data.answer,
          points: data.points,
        });
      })
      .catch(errCat => {
        setError('Failed to fetch categories.');
        console.error('Category fetch error:', errCat);
      });
    })
    .catch(err => {
      setError('Failed to fetch question.');
    });
  }, [id]);

  const handleChange = (e) => {
    setQuestionData({ ...questionData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const token = localStorage.getItem('token');
  
    let optionsToSend = questionData.options;
    // Proveri da li je options niz (npr. korisnik menjao u textarea)
    try {
      const parsed = JSON.parse(questionData.options);
      // Ako je parsed niz, onda optionsToSend treba da ostane JSON string, znači nema menjanja
      if (!Array.isArray(parsed)) {
        setError('Options must be a JSON array.');
        return;
      }
    } catch (err) {
      setError('Options must be a valid JSON string.');
      return;
    }
  
    axios.put(`http://127.0.0.1:8000/api/questions/${id}`, {
      ...questionData,
      options: optionsToSend,  // Ovo je string, JSON validan
    }, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    })
    .then(() => {
      setMessage('Question updated successfully.');
      setError('');
      setTimeout(() => navigate('/questions'), 1500);
    })
    .catch(err => {
      const msg = err.response?.data?.message || 'Update failed.';
      setError(msg);
    });
  };
  
  

  return (
    <div>
      <h2>Edit Question</h2>
      {error && <p style={{ color: 'red' }}>{error}</p>}
      {message && <p style={{ color: 'green' }}>{message}</p>}

      <form onSubmit={handleSubmit}>
        <label>Category:</label>
        <select name="category_id" value={questionData.category_id} onChange={handleChange}>
          <option value="">Select Category</option>
          {categories.map(cat => (
            <option key={cat.id} value={cat.id}>{cat.name}</option>
          ))}
        </select>

        <label>Question:</label>
        <input type="text" name="question" value={questionData.question} onChange={handleChange} />

        <label>Options (as JSON):</label>
        <textarea name="options" value={questionData.options} onChange={handleChange} rows={6} />

        <label>Correct Answer:</label>
        <input type="text" name="answer" value={questionData.answer} onChange={handleChange} />

        <label>Points:</label>
        <input type="number" name="points" value={questionData.points} onChange={handleChange} />

        <button type="submit">Save Changes</button>
      </form>
    </div>
  );
}

export default QuestionEdit;
