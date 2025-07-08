import logo from './logo.svg';
import './App.css';
import React from 'react';
import axios from 'axios';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './components/login/login';
import NavBar from './components/NavBar/NavBar';
import { useState } from 'react';


import PrivateRoute from './PrivateRoute'; // Importujemo PrivateRoute komponentu
import QuestionList from './components/QuestionList/QuestionList'; // Importujemo QuestionListList komponentu
import QuestionDetails from './components/QuestionDetails/QuestionDetails'; // Importujemo QuestionDetails komponentu
import Dashboard from './components/Dashboard/Dashboard'; // Importujemo Dashboard komponentu
import AdminRoute from './components/AdminRoute/AdminRoute'; // Importujemo AdminRoute komponentu
import Leaderboard from './components/Leaderboard/Leaderboard'; // importuj komponentu
import Profile from './components/Profile/Profile'; // Importujemo Profile komponentu

function App() {
  const [authChanged, setAuthChanged] = useState(false);
  <NavBar authChanged={authChanged} />

  return (
    <Router>
      <NavBar />
      <Routes>
        <Route path="/login" element={<Login />} />
  
        {/* JAVNA RUTA */}
        <Route path="/questions" element={<QuestionList />} />
  <Route path="/profile" element={<Profile />} />

        {/* ZAŠTIĆENE RUTE */}
               <Route path="/leaderboards" element={
              <PrivateRoute>
            <Leaderboard />
            </PrivateRoute>
} />
  
        {/* ADMIN ZAŠTIĆENE RUTE */}

        <Route path="/questions/:id" element={
          <AdminRoute>
            <QuestionDetails />
          </AdminRoute>
        } />

        <Route path="/dashboard" element={
          <AdminRoute>
            <Dashboard />
          </AdminRoute>
        } />
 

      </Routes>
    </Router>
  );

}

export default App;
