import './App.css';
import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom';

import Login from './components/login/login';
import NavBar from './components/NavBar/NavBar';
import PrivateRoute from './PrivateRoute';
import AdminRoute from './components/AdminRoute/AdminRoute';

import QuestionList from './components/QuestionList/QuestionList';
import QuestionDetails from './components/QuestionDetails/QuestionDetails';
import Dashboard from './components/Dashboard/Dashboard';
import Leaderboard from './components/Leaderboard/Leaderboard';
import Profile from './components/Profile/Profile';
import Register from './components/Register/Register';
import QuestionEdit from './components/QuestionEdit/QuestionEdit';
import QuestionCreate from './components/QuestionCreate/QuestionCreate';
import CategoryCreate from './components/CategoryCreate/CategoryCreate';
import CategoryList from './components/CategoryList/CategoryList';
import CategoryEdit from './components/CategoryEdit/CategoryEdit';
import QuizPage from './components/QuizPage/QuizPage';
import QuizSetupPage from './components/QuizSetup/QuizSetupPage';

function App() {
  const [authChanged, setAuthChanged] = useState(false);

  const GuestRoute = ({ children }) => {
    const isLoggedIn = Boolean(localStorage.getItem('token'));

    if (isLoggedIn) {
      return <Navigate to="/profile" replace />;
    }

    return children;
  };

  return (
    <Router>
      <NavBar />

      <Routes>

      <Route
  path="/"
  element={
    localStorage.getItem('token') 
      ? <PrivateRoute><Profile /></PrivateRoute> 
      : <Navigate to="/login" replace />
  }
/>

        <Route path="/login" element={<Login />} />

        <Route
          path="/register"
          element={
            <GuestRoute>
              <Register />
            </GuestRoute>
          }
        />

        <Route path="/quiz" element={<QuizSetupPage />} />
        <Route path="/quiz/play" element={<QuizPage />} />

        {/* JAVNE RUTE */}
        <Route path="/questions" element={<QuestionList />} />
        <Route path="/profile" element={<Profile />} />

        {/* PRIVATE */}
        <Route
          path="/leaderboards"
          element={
            <PrivateRoute>
              <Leaderboard />
            </PrivateRoute>
          }
        />

        {/* ADMIN */}
        <Route
          path="/questions/:id"
          element={
            <AdminRoute>
              <QuestionDetails />
            </AdminRoute>
          }
        />

        <Route
          path="/questions/edit/:id"
          element={
            <AdminRoute>
              <QuestionEdit />
            </AdminRoute>
          }
        />

        <Route
          path="/dashboard"
          element={
            <AdminRoute>
              <Dashboard />
            </AdminRoute>
          }
        />

        <Route
          path="/questions/create"
          element={
            <AdminRoute>
              <QuestionCreate />
            </AdminRoute>
          }
        />

        <Route
          path="/categories/create"
          element={
            <AdminRoute>
              <CategoryCreate />
            </AdminRoute>
          }
        />

        <Route
          path="/categories"
          element={
            <AdminRoute>
              <CategoryList />
            </AdminRoute>
          }
        />

        <Route
          path="/categories/edit/:id"
          element={
            <AdminRoute>
              <CategoryEdit />
            </AdminRoute>
          }
        />

      </Routes>
    </Router>
  );
}

export default App;
