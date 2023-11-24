import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';

const Login = () => {
  const [credentials, setCredentials] = useState({ name: '', password: '' });
  const navigate = useNavigate();

  const handleInputChange = (e) => {
    setCredentials({ ...credentials, [e.target.name]: e.target.value });
  };

  const handleLogin = async () => {
    try {
      if (!credentials.name || !credentials.password) {
        Swal.fire({
          icon: 'error',
          title: 'Error de inicio de sesión',
          text: 'Por favor, completa todos los campos.',
        });
        return;
      }

      const response = await fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `name=${credentials.name}&password=${credentials.password}`,
      });

      const result = await response.json();

      if (response.ok) {
        localStorage.setItem('token', result.token);
        navigate('/users');
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error de inicio de sesión',
          text: 'Credenciales incorrectas. Por favor, inténtalo de nuevo.',
        });
      }
    } catch (error) {
      console.error('Error during login:', error);
    }
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-screen bg-gray-100">
      <img src="dumbo.png" alt="Dumbo" className="mb-8" />

      <div className="text-center">
        <h1 className="text-3xl font-bold mb-4">Bienvenido al sistema de administración de usuarios de Dumbo</h1>

        <div className="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
          <form>
            <label htmlFor="name" className="block mb-2">Usuario:</label>
            <input
              type="text"
              id="name"
              name="name"
              value={credentials.name}
              onChange={handleInputChange}
              className="w-full rounded-md border p-2 mb-4"
            />

            <label htmlFor="password" className="block mb-2">Contraseña:</label>
            <input
              type="password"
              id="password"
              name="password"
              value={credentials.password}
              onChange={handleInputChange}
              className="w-full rounded-md border p-2 mb-4"
            />

            <button
              type="button"
              onClick={handleLogin}
              className="w-full bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-700"
            >
              Iniciar Sesión
            </button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Login;
