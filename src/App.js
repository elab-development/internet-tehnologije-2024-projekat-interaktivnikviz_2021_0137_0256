import logo from './logo.svg';
import './App.css';
import React from 'react';
import axios from 'axios';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './components/login/login';
import NavBar from './components/NavBar/NavBar';

import PrivateRoute from './PrivateRoute'; // Importujemo PrivateRoute komponentu
import QuestionList from './components/QuestionList/QuestionList'; // Importujemo QuestionListList komponentu
import QuestionDetails from './components/QuestionDetails/QuestionDetails'; // Importujemo QuestionDetails komponentu
import Dashboard from './components/Dashboard/Dashboard'; // Importujemo Dashboard komponentu
import AdminRoute from './components/AdminRoute/AdminRoute'; // Importujemo AdminRoute komponentu

function App() {
  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

  const token = document.querySelector('meta[name="csrf-token"]');
  if (token) {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
  } else {
      console.error('CSRF token not found in document.');
  }

 return (
        <Router>
            <NavBar /> {/* Uključujemo NavBar komponentu */}
            <Routes>
                <Route path="/login" element={<Login />} />
           <Route path="/questions" element={
          <PrivateRoute> {/* Protect ruta kojoj prosledjujemo dete komponentu QuestionList */}
            <QuestionList />
          </PrivateRoute>
        } />
        <Route path="/questions/:id" element={
          <PrivateRoute> {/* Protect question details */}
            <QuestionDetails />
          </PrivateRoute>
        } />
        <Route path="/dashboard" element={
          <AdminRoute> {/* Protect dashboard */}
            <Dashboard />
          </AdminRoute>
        } />



            </Routes>
        </Router>

    );

}

export default App;
