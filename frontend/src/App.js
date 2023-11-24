// src/App.js
import React from 'react';
import './App.css';

function App() {
  return (
    <div className="bg-gray-100 h-screen flex items-center justify-center">
      <div className="text-center">
        <h1 className="text-4xl font-bold mb-6">
          Bienvenido al Sistema de Administración de Usuarios de Dumbo
        </h1>
        <div className="space-x-4">
          <button className="bg-blue-500 text-white px-4 py-2 rounded">
            Registrarse
          </button>
          <button className="bg-green-500 text-white px-4 py-2 rounded">
            Iniciar Sesión
          </button>
        </div>
      </div>
    </div>
  );
}

export default App;
