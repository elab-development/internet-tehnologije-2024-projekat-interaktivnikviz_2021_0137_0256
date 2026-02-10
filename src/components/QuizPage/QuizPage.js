import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useSearchParams } from 'react-router-dom';
import styles from './QuizPage.module.css';

const QuizPage = () => {
  const [questions, setQuestions] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [score, setScore] = useState(0);
  const [selectedOption, setSelectedOption] = useState(null);
  const [showResult, setShowResult] = useState(false);
  const [isGuest, setIsGuest] = useState(false);
  const [timeLeft, setTimeLeft] = useState(10);
  const [timerRunning, setTimerRunning] = useState(true);
  const [answersLog, setAnswersLog] = useState([]);

  const [searchParams] = useSearchParams();
  const type = searchParams.get('type') || 'mix';
  const categoryId = searchParams.get('category_id');

  const shuffleArray = (array) => [...array].sort(() => Math.random() - 0.5);

  const fetchQuestions = () => {
    const token = localStorage.getItem('token');

    let url = 'http://127.0.0.1:8000/api/quiz/random';
    let params = {};

    if (type === 'category' && categoryId) {
      url = `http://127.0.0.1:8000/api/quiz/category/${categoryId}`;
    } else {
      params.type = type;
    }

    axios.get(url, {
      headers: token ? { Authorization: `Bearer ${token}` } : {},
      params
    })
    .then(res => {
      setQuestions(res.data.data.map(q => ({
        ...q,
        options: shuffleArray(q.options)
      })));
      setCurrentIndex(0);
      setScore(0);
      setSelectedOption(null);
      setShowResult(false);
      setIsGuest(false);
      setTimeLeft(10);
      setTimerRunning(true);
      setAnswersLog([]);
    });
  };

  useEffect(() => { fetchQuestions(); }, [type, categoryId]);

  useEffect(() => {
    if (!timerRunning || selectedOption || showResult) return;
    if (timeLeft === 0) {
      setSelectedOption('timeout');
      setTimerRunning(false);
      setTimeout(nextQuestion, 800);
      return;
    }
    const timer = setTimeout(() => setTimeLeft(t => t - 1), 1000);
    return () => clearTimeout(timer);
  }, [timeLeft, timerRunning, selectedOption, showResult]);

  const handleAnswer = (option) => {
    if (selectedOption) return;

    const q = questions[currentIndex];
    const correct = option === q.answer;

    setSelectedOption(option);
    setTimerRunning(false);

    setAnswersLog(prev => [...prev, {
      question: q.question,
      selected: option,
      correctAnswer: q.answer,
      isCorrect: correct
    }]);

    if (correct) setScore(s => s + q.points);
  };

  const nextQuestion = () => {
    setSelectedOption(null);
    setTimeLeft(10);
    setTimerRunning(true);

    if (currentIndex + 1 < questions.length) {
      setCurrentIndex(i => i + 1);
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

    axios.post('http://127.0.0.1:8000/api/leaderboards',
      { points: score },
      { headers: { Authorization: `Bearer ${token}` } }
    ).finally(() => setShowResult(true));
  };

  const restartQuiz = () => fetchQuestions();

  if (!questions.length) return <p className={styles.loading}>Učitavanje pitanja...</p>;

  const correctCount = answersLog.filter(a => a.isCorrect).length;
  const accuracy = Math.round((correctCount / answersLog.length) * 100);
  const wrongAnswers = answersLog.filter(a => !a.isCorrect);

  return (
    <div className={styles.quizContainer}>
      {showResult ? (
        <div className={styles.result}>
          <h2>Kviz završen 🎉</h2>

          <div className={styles.scoreBox}>
            <div>
              <strong>{score}</strong>
              <span>Poena</span>
            </div>
            <div>
              <strong>{accuracy}%</strong>
              <span>Tačnost</span>
            </div>
          </div>

          <div className={styles.progressWrapper}>
            <div
              className={`${styles.progressBar} ${
                accuracy >= 80 ? styles.good :
                accuracy >= 50 ? styles.mid : styles.bad
              }`}
              style={{ width: `${accuracy}%` }}
            />
          </div>

          {wrongAnswers.length > 0 && (
            <div className={styles.review}>
              <h4>Pregled pogrešnih odgovora</h4>

              {wrongAnswers.map((item, i) => (
                <div key={i} className={styles.reviewItem}>
                  <div className={styles.reviewHeader}>
                    <span className={styles.icon}>✖</span>
                    <strong>{item.question}</strong>
                  </div>

                  <div className={styles.badges}>
                    <span className={styles.badgeWrong}>
                      Vaš odgovor: {item.selected}
                    </span>
                    <span className={styles.badgeCorrect}>
                      Tačan: {item.correctAnswer}
                    </span>
                  </div>
                </div>
              ))}
            </div>
          )}

          {isGuest && (
            <p className={styles.warning}>
              Prijavite se da biste sačuvali rezultat.
            </p>
          )}

          <button className={styles.nextButton} onClick={restartQuiz}>
            Ponovi kviz
          </button>
        </div>
      ) : (
        <>
          <h3>Pitanje {currentIndex + 1} / {questions.length}</h3>

          <p className={styles.question}>
            <strong>{questions[currentIndex].question}</strong>
          </p>

          <div className={styles.timerBarWrapper}>
            <div
              className={styles.timerBar}
              style={{ width: `${(timeLeft / 10) * 100}%` }}
            />
          </div>

          <div className={styles.options}>
            {questions[currentIndex].options.map((opt, i) => {
              let btnClass = styles.optionButton;
              let isCorrectAnswer = opt === questions[currentIndex].answer;
              let isSelected = opt === selectedOption;

              if (selectedOption) {
                if (isCorrectAnswer) {
                  btnClass += ` ${styles.correct}`;
                } else if (isSelected) {
                  btnClass += ` ${styles.wrong}`;
                } else {
                  btnClass += ` ${styles.faded}`;
                }
              }

              return (
                <button
                  key={i}
                  disabled={!!selectedOption}
                  onClick={() => handleAnswer(opt)}
                  className={btnClass}
                >
                  {opt}
                </button>
              );
            })}
          </div>

          {selectedOption && (
            <button className={styles.nextButton} onClick={nextQuestion}>
              Sledeće pitanje
            </button>
          )}
        </>
      )}
    </div>
  );
};

export default QuizPage;