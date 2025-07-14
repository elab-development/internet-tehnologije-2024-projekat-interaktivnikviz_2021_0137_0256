import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './Profile.module.css';
import AvatarModal from './AvatarModal';

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
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
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
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    .then(() => {
      setProfile(prev => ({ ...prev, username: newUsername }));
      alert("Korisničko ime uspešno promenjeno");
    })
    .catch(err => {
      if (err.response?.status === 422) {
        setUsernameError("Korisničko ime je zauzeto ili neispravno");
        setNewUsername(profile.username); // Reset na staro
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
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    .then(() => {
      alert("Šifra je uspešno promenjena");
      setPasswords({ current: '', new: '', confirm: '' });
    })
    .catch(err => {
      console.log(err.response); // Log the error response for debugging
    
      if (err.response?.status === 422) {
        setPasswordError("Nova šifra ne ispunjava uslove");
      } else if (err.response?.status === 403) {
        setPasswordError("Stara šifra nije tačna");
      } else {
        setPasswordError("Greška pri promeni šifre");
      }
    });
  };

  if (error) return <p>{error}</p>;
  if (!profile) return <p>Učitavanje...</p>;

  return (
    <div className={styles.profileContainer}>
      <div className={styles.avatarWrapper}>
        <img
          src={profile.avatar && profile.avatar !== 'null' && profile.avatar !== '' 
            ? `/avatars/${profile.avatar}` 
            : '/avatars/default.png'}
          alt="Avatar"
          className={styles.avatar}
        />
        <button onClick={() => setIsModalOpen(true)} className={styles.avatarBtn}>
          Promeni avatar
        </button>
      </div>

      <AvatarModal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        onSelect={handleAvatarChange}
      />
      <h4><strong>Username:</strong> {profile.username}</h4>
      <h4><strong>Email:</strong> {profile.email}</h4>
      <h4><strong>Poeni:</strong> {profile.points}</h4>

      <div className={styles.section}>
        <label>Korisničko ime:</label>
        <input
          type="text"
          value={newUsername}
          onChange={(e) => setNewUsername(e.target.value)}
        />
        <button onClick={handleUsernameChange}>Izmeni ime</button>
        {usernameError && <p className={styles.error}>{usernameError}</p>}
      </div>

      <div className={styles.section}>
        <label>Stara šifra:</label>
        <input
          type="password"
          value={passwords.current}
          onChange={(e) => setPasswords(prev => ({ ...prev, current: e.target.value }))}
        />
        <label>Nova šifra:</label>
        <input
          type="password"
          value={passwords.new}
          onChange={(e) => setPasswords(prev => ({ ...prev, new: e.target.value }))}
        />
        <label>Potvrdi novu šifru:</label>
        <input
          type="password"
          value={passwords.confirm}
          onChange={(e) => setPasswords(prev => ({ ...prev, confirm: e.target.value }))}
        />
        <button onClick={handlePasswordChange}>Promeni šifru</button>
        {passwordError && <p className={styles.error}>{passwordError}</p>}
      </div>

      
    </div>
  );
};

export default Profile;
