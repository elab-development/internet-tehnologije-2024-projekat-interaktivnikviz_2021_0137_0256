import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './Profile.module.css';
import AvatarModal from './AvatarModal';
import { motion, AnimatePresence } from 'framer-motion';

const Loader = () => (
  <div className={styles.loaderContainer}>
    <div className={styles.loader}></div>
  </div>
);

const Profile = () => {
  const [profile, setProfile] = useState(null);
  const [error, setError] = useState(null);
  const [isModalOpen, setIsModalOpen] = useState(false);

  const [newUsername, setNewUsername] = useState('');
  const [usernameError, setUsernameError] = useState(null);

  const [passwords, setPasswords] = useState({
    current: '',
    new: '',
    confirm: ''
  });
  const [passwordError, setPasswordError] = useState(null);

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/profile', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    .then(res => {
      setProfile(res.data);
      setNewUsername(res.data.username);
    })
    .catch(() => setError("Došlo je do greške pri učitavanju profila"));
  }, []);

  const handleAvatarChange = (avatarName) => {
    axios.post('http://127.0.0.1:8000/api/profile/avatar', { avatar: avatarName }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    .then(() => {
      setProfile(prev => ({ ...prev, avatar: avatarName }));
      setIsModalOpen(false);
    })
    .catch(() => alert("Greška pri promeni avatara"));
  };

  const handleUsernameChange = () => {
    setUsernameError(null);
    axios.patch('http://127.0.0.1:8000/api/profile/update-username', {
      username: newUsername
    }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    .then(() => {
      setProfile(prev => ({ ...prev, username: newUsername }));
      alert("Korisničko ime uspešno promenjeno");
    })
    .catch(err => {
      if (err.response?.status === 422) {
        setUsernameError("Korisničko ime je zauzeto ili neispravno");
        setNewUsername(profile.username);
      } else {
        alert("Greška prilikom promene imena");
      }
    });    
  };

  const handlePasswordChange = () => {
    setPasswordError(null);

    if (passwords.new !== passwords.confirm) {
      setPasswordError("Nove šifre se ne poklapaju");
      return;
    }

    axios.patch('http://127.0.0.1:8000/api/profile/update-password', {
      current_password: passwords.current,
      new_password: passwords.new,
      new_password_confirmation: passwords.confirm
    }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    .then(() => {
      alert("Šifra je uspešno promenjena");
      setPasswords({ current: '', new: '', confirm: '' });
    })
    .catch(err => {
      if (err.response?.status === 422) {
        setPasswordError("Nova šifra ne ispunjava uslove");
      } else if (err.response?.status === 403) {
        setPasswordError("Stara šifra nije tačna");
      } else {
        setPasswordError("Greška pri promeni šifre");
      }
    });
  };

  if (error) return <p className={styles.error}>{error}</p>;
  if (!profile) return <Loader />;

  return (
    <motion.div
      className={styles.container}
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      exit={{ opacity: 0, y: -20 }}
      transition={{ duration: 0.5 }}
    >
      <div className={styles.avatarWrapper}>
        <img
          src={profile.avatar && profile.avatar !== 'null' && profile.avatar !== ''
            ? `/avatars/${profile.avatar}`
            : '/avatars/default.png'}
          alt="Avatar"
          className={styles.avatar}
        />
        <button onClick={() => setIsModalOpen(true)} className={styles.changeAvatarBtn}>
          Promeni avatar
        </button>
      </div>

      <AvatarModal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        onSelect={handleAvatarChange}
      />

      <div className={styles.infoSection}>
        <h3>Informacije o korisniku</h3>
        <p><strong>Korisničko ime:</strong> {profile.username}</p>
        <p><strong>Email:</strong> {profile.email}</p>
        <p><strong>Poeni:</strong> {profile.points}</p>
      </div>

      <div className={styles.section}>
        <h3>Izmena korisničkog imena</h3>
        <input
          type="text"
          value={newUsername}
          onChange={e => setNewUsername(e.target.value)}
          className={styles.input}
        />
        <button onClick={handleUsernameChange} className={styles.button}>
          Sačuvaj izmene
        </button>
        {usernameError && <p className={styles.error}>{usernameError}</p>}
      </div>

      <div className={styles.section}>
        <h3>Promena šifre</h3>
        <input
          type="password"
          placeholder="Stara šifra"
          value={passwords.current}
          onChange={e => setPasswords(prev => ({ ...prev, current: e.target.value }))}
          className={styles.input}
        />
        <input
          type="password"
          placeholder="Nova šifra"
          value={passwords.new}
          onChange={e => setPasswords(prev => ({ ...prev, new: e.target.value }))}
          className={styles.input}
        />
        <input
          type="password"
          placeholder="Potvrdi novu šifru"
          value={passwords.confirm}
          onChange={e => setPasswords(prev => ({ ...prev, confirm: e.target.value }))}
          className={styles.input}
        />
        <button onClick={handlePasswordChange} className={styles.button}>
          Promeni šifru
        </button>
        {passwordError && <p className={styles.error}>{passwordError}</p>}
      </div>
    </motion.div>
  );
};

export default Profile;
