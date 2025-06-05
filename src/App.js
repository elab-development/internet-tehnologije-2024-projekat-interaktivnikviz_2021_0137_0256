import logo from './logo.svg';
import './App.css';
import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './components/login/login';

import PrivateRoute from './PrivateRoute'; // Importujemo PrivateRoute komponentu
import QuestionList from './components/QuestionList/QuestionList'; // Importujemo QuestionListList komponentu

function App() {
 return (
        <Router>
            <Routes>
                <Route path="/login" element={<Login />} />
           <Route path="/questions" element={
          <PrivateRoute> {/* Protect ruta kojo prosledjujemo dete komponentu QuestionList */}
            <QuestionList />
          </PrivateRoute>
        } />
            </Routes>
        </Router>

    );

}

export default App;
