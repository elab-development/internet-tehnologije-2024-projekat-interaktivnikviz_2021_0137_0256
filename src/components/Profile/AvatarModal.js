// src/components/AvatarModal.js
import React from 'react';
import styles from './AvatarModal.module.css';

const avatars = Array.from({ length: 9 }, (_, i) => `avatar${i + 1}.png`);

const AvatarModal = ({ isOpen, onClose, onSelect }) => {
  if (!isOpen) return null;

  return (
    <div className={styles.modalOverlay}>
      <div className={styles.modal}>
        <h3>Izaberi avatar</h3>
        <div className={styles.avatarGrid}>
          {avatars.map((avatar, index) => (
            <img
              key={index}
              src={`/avatars/${avatar}`}
              alt={`Avatar ${index + 1}`}
              className={styles.avatarOption}
              onClick={() => onSelect(avatar)}
            />
          ))}
        </div>
        <button className={styles.closeBtn} onClick={onClose}>Zatvori</button>
      </div>
    </div>
  );
};

export default AvatarModal;
