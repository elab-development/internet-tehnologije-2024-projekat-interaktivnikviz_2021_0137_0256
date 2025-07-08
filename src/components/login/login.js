import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import styles from './login.module.css'; // Import your CSS module for styling

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    const navigate = useNavigate();

    const handleLogin = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');


       try {
            const response = await axios.post('http://127.0.0.1:8000/api/admin/login', { email, password }, {
                headers: { 'Accept': 'application/json' }
            });
 
            localStorage.setItem('token', response.data.access_token);
            window.location.href = '/dashboard';  // Preusmeravanje na admin dashboard
            console.log('Admin login successful:', response.data);
        } catch (adminError) {
            try {
                const userResponse = await axios.post('http://127.0.0.1:8000/api/login', { email, password }, {
                    headers: { 'Accept': 'application/json' }
                });
                localStorage.setItem('token', userResponse.data.access_token);
                window.location.href = '/leaderboards';  // Preusmeravanje na pitanja OVO JE PLACEHOLDER
            } catch (userError) {
                console.error('Login failed:', userError);
                setError('Neuspesno logovanje. Proverite email i lozinku.');
            }
        } finally {
            setLoading(false);
        }
    };

 
    return (
        <div className={styles['login-container']}>
            <h2>Login</h2>
            <form onSubmit={handleLogin}>
                <div>
                    <label>Email</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                    />
                </div>
                <div>
                    <label>Password</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                    />
                </div>
                <button type="submit" disabled={loading}>
                    {loading ? 'Logging in...' : 'Login'}
                </button>
                {error && <p>{error}</p>}
            </form>
        </div>
    );
}
 
export default Login;
