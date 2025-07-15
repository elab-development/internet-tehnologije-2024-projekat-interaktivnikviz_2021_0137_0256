import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './QuizPage.module.css';

const QuizPage = () => {
  const [questions, setQuestions] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [score, setScore] = useState(0);
  const [selectedOption, setSelectedOption] = useState(null);
  const [showResult, setShowResult] = useState(false);
  const [isCorrect, setIsCorrect] = useState(null);
  const [isGuest, setIsGuest] = useState(false);
  const [timeLeft, setTimeLeft] = useState(10);
  const [timerRunning, setTimerRunning] = useState(true);

  const shuffleArray = (array) => {
    return [...array].sort(() => Math.random() - 0.5);
  };

  const fetchQuestions = () => {
    const token = localStorage.getItem('token');
    axios.get('http://127.0.0.1:8000/api/quiz/random', {
      headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
      const randomizedQuestions = res.data.data.map(q => ({
        ...q,
        options: shuffleArray(q.options),
      }));

      setQuestions(randomizedQuestions);
      setCurrentIndex(0);
      setScore(0);
      setSelectedOption(null);
      setIsCorrect(null);
      setShowResult(false);
      setIsGuest(false);
      setTimeLeft(10);
      setTimerRunning(true);
    })
    .catch(() => alert("Greška pri učitavanju pitanja."));
  };

  useEffect(() => {
    fetchQuestions();
  }, []);

  useEffect(() => {
    if (!timerRunning || selectedOption || showResult) return;

    if (timeLeft === 0) {
      setIsCorrect(false);
      setSelectedOption('timeout'); // označava da je vreme isteklo
      setTimerRunning(false);
      setTimeout(() => {
        nextQuestion();
      }, 1000);
      return;
    }

    const timer = setTimeout(() => {
      setTimeLeft(prev => prev - 1);
    }, 1000);

    return () => clearTimeout(timer);
  }, [timeLeft, timerRunning, selectedOption, showResult]);

  const handleAnswer = (option) => {
    if (selectedOption) return; // spreči dupli klik

    const correct = option === questions[currentIndex].answer;
    setIsCorrect(correct);
    setSelectedOption(option);
    setTimerRunning(false);

    if (correct) {
      setScore(prev => prev + questions[currentIndex].points);
    }
  };

  const nextQuestion = () => {
    setSelectedOption(null);
    setIsCorrect(null);
    setTimeLeft(10);
    setTimerRunning(true);

    if (currentIndex + 1 < questions.length) {
      setCurrentIndex(prev => prev + 1);
    } else {
      submitScore();
    }
  };

  const submitScore = () => {
    const token = localStorage.getItem('token');

    if (!token) {
      setIsGuest(true);
      setShowResult(true);
      return;
    }

    axios.post('http://127.0.0.1:8000/api/leaderboards', {
      points: score
    }, {
      headers: { Authorization: `Bearer ${token}` }
    })
    .catch(() => {
      alert("Greška pri upisu rezultata.");
    })
    .finally(() => {
      setShowResult(true);
    });
  };

  const restartQuiz = () => {
    fetchQuestions();
  };

  if (questions.length === 0) return <p>Učitavanje pitanja...</p>;

  return (
    <div className={styles.quizContainer}>
      {showResult ? (
        <div className={styles.result}>
          <h2>Kviz završen!</h2>
          <p>Ukupno osvojenih poena: {score}</p>
          {isGuest && (
            <p className={styles.warning}>Da biste sačuvali rezultat, prijavite se.</p>
          )}
          <button className={styles.nextButton} onClick={restartQuiz}>
            Ponovi kviz
          </button>
        </div>
      ) : (
        <>
          <h3>Pitanje {currentIndex + 1} od {questions.length}</h3>
          <p><strong>{questions[currentIndex].question}</strong></p>
          <p>Poeni: {questions[currentIndex].points}</p>

          {/* Tajmer i loading bar */}
          <div className={styles.timerBarWrapper}>
            <div
              className={styles.timerBar}
              style={{ width: `${(timeLeft / 10) * 100}%` }}
            />
          </div>

          <div className={styles.options}>
            {questions[currentIndex].options.map((option, index) => {
              const isAnswer = option === questions[currentIndex].answer;
              const isSelected = option === selectedOption;

              let buttonClass = '';
              if (selectedOption) {
                if (isAnswer) {
                  buttonClass = styles.correct;
                } else if (isSelected && !isAnswer) {
                  buttonClass = styles.wrong;
                }
              }

              return (
                <button
                  key={index}
                  disabled={!!selectedOption}
                  onClick={() => handleAnswer(option)}
                  className={buttonClass}
                >
                  {option}
                </button>
              );
            })}
          </div>

          {selectedOption && (
            <button className={styles.nextButton} onClick={nextQuestion}>
              {currentIndex === questions.length - 1 ? "Završi kviz" : "Sledeće pitanje"}
            </button>
          )}
        </>
      )}
    </div>
  );
};

export default QuizPage;
