import React, { useEffect, useState } from 'react';
import axios from 'axios';
import styles from './Profile.module.css';
import AvatarModal from './AvatarModal';

const Profile = () => {
  const [profile, setProfile] = useState(null);
  const [error, setError] = useState(null);
  const [isModalOpen, setIsModalOpen] = useState(false);

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/profile', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    .then(res => setProfile(res.data))
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

  if (error) return <p>{error}</p>;
  if (!profile) return <p>Učitavanje...</p>;

  return (
    <div className={styles.profileContainer}>
      <div className={styles.avatarWrapper}>
       <img
  src={profile.avatar ? `/avatars/${profile.avatar}` : '/avatars/default.jpg'}
  alt="Avatar"
  className={styles.avatar}
/>
        <button onClick={() => setIsModalOpen(true)} className={styles.avatarBtn}>
          Promeni avatar
        </button>
      </div>
      <h2 className={styles.profileName}>{profile.username}</h2>
      <p className={styles.profileEmail}>{profile.email}</p>
      <p className={styles.profilePoints}>Poeni: {profile.points ?? 0}</p>

      <AvatarModal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        onSelect={handleAvatarChange}
      />
    </div>
  );
};

export default Profile;
