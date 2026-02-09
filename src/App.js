import logo from './logo.svg';
import './App.css';
import React from 'react';
import axios from 'axios';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './components/login/login';
import NavBar from './components/NavBar/NavBar';
import { useState } from 'react';
import { Navigate } from 'react-router-dom'; // Importujemo Navigate za preusmeravanje


import PrivateRoute from './PrivateRoute'; // Importujemo PrivateRoute komponentu
import QuestionList from './components/QuestionList/QuestionList'; // Importujemo QuestionListList komponentu
import QuestionDetails from './components/QuestionDetails/QuestionDetails'; // Importujemo QuestionDetails komponentu
import Dashboard from './components/Dashboard/Dashboard'; // Importujemo Dashboard komponentu
import AdminRoute from './components/AdminRoute/AdminRoute'; // Importujemo AdminRoute komponentu
import Leaderboard from './components/Leaderboard/Leaderboard'; // importuj komponentu
import Profile from './components/Profile/Profile'; // Importujemo Profile komponentu
import Register from './components/Register/Register'; // Importujemo Register komponentu
import QuestionEdit from './components/QuestionEdit/QuestionEdit'; // Importujemo QuestionEdit komponentu
import QuestionCreate from './components/QuestionCreate/QuestionCreate'; // Importujemo QuestionCreate komponentu
import CategoryCreate from './components/CategoryCreate/CategoryCreate';
import CategoryList from './components/CategoryList/CategoryList';
import CategoryEdit from './components/CategoryEdit/CategoryEdit'; // Importujemo CategoryEdit komponentu
import QuizPage from './components/QuizPage/QuizPage';
import QuizSetupPage from './components/QuizSetup/QuizSetupPage';


function App() {
  const [authChanged, setAuthChanged] = useState(false);
  

  const GuestRoute = ({ children }) => {
    const isLoggedIn = Boolean(localStorage.getItem('token')); // ili kako ti proveravaš login
  
    if (isLoggedIn) {
      // Ako je korisnik ulogovan, preusmeri ga na dashboard ili profil
      return <Navigate to="/profile" replace />;
    }
  
    // Ako nije ulogovan, prikazi komponentu (npr. Register)
    return children;
  };

  return (
    <Router>
      <Routes>
      <Route path="/" element={
        <Navigate to={localStorage.getItem('token') ? "/profile" : "/login"} replace />
      } />
    
      </Routes>
      <NavBar />
      <Routes>
        <Route path="/login" element={<Login />} />

        <Route path="/register" element={
          <GuestRoute>
            <Register />
          </GuestRoute>
        } />
    <Route path="/quiz" element={<QuizSetupPage />} />
    <Route path="/quiz/play" element={<QuizPage />} />

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

        <Route path="/questions/edit/:id" element={
        <AdminRoute>
          <QuestionEdit />
        </AdminRoute>
        } />

        <Route path="/dashboard" element={
          <AdminRoute>
            <Dashboard />
          </AdminRoute>
        } />
 <Route path="/questions/create" element={<AdminRoute><QuestionCreate /></AdminRoute>} />
<Route path="/categories/create" element={<AdminRoute><CategoryCreate /></AdminRoute>} />
<Route path="/categories" element={<AdminRoute><CategoryList /></AdminRoute>} />
<Route path="/categories/edit/:id" element={<AdminRoute><CategoryEdit /></AdminRoute>} />

      </Routes>
    </Router>
  );

}

export default App;
