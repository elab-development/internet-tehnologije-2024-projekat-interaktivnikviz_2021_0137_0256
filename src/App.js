import logo from './logo.svg';
import './App.css';
import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './components/login/login';

import PrivateRoute from './PrivateRoute'; // Importujemo PrivateRoute komponentu
import QuestionList from './components/QuestionList/QuestionList'; // Importujemo QuestionListList komponentu
import QuestionDetails from './components/QuestionDetails/QuestionDetails'; // Importujemo QuestionDetails komponentu
import Dashboard from './components/Dashboard/Dashboard'; // Importujemo Dashboard komponentu
import AdminRoute from './components/AdminRoute/AdminRoute'; // Importujemo AdminRoute komponentu

function App() {
 return (
        <Router>
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
