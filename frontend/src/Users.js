import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Modal from 'react-modal';
import Swal from 'sweetalert2';

const Users = () => {
  const [users, setUsers] = useState([]);
  const [newUser, setNewUser] = useState({
    name: '',
    last_name: '',
    dni: '',
    email: '',
    password: '',
    points: '',
  });
  const [selectedUserId, setSelectedUserId] = useState(null);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const navigate = useNavigate();

  const [searchTerm, setSearchTerm] = useState('');
  const [filteredUsers, setFilteredUsers] = useState([]);
  

  useEffect(() => {
    const token = localStorage.getItem('token');

    if (token) {
      fetch('http://127.0.0.1:8000/api/users', {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
        },
      })
        .then(response => response.json())
        .then(data => setUsers(data))
        .catch(error => console.error('Error fetching users:', error));
    } else {
      navigate('/');
    }
  }, [navigate]);

  const handleLogout = () => {
    localStorage.removeItem('token');
    navigate('/');
  };

  const handleCreateUser = () => {
    const token = localStorage.getItem('token');

    fetch('http://127.0.0.1:8000/api/users/', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(newUser),
    })
      .then(response => response.json())
      .then(data => {
        fetch('http://127.0.0.1:8000/api/users', {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${token}`,
          },
        })
          .then(response => response.json())
          .then(updatedUsers => setUsers(updatedUsers))
          .catch(error => console.error('Error fetching users after create:', error));

        setNewUser({
          name: '',
          last_name: '',
          dni: '',
          email: '',
          password: '',
          points: '',
        });
        setIsModalOpen(false);
      })
      .catch(error => console.error('Error creating user:', error));
  };

  useEffect(() => {
    const filteredUsers = searchTerm
      ? users.filter((user) => user.dni.toLowerCase().includes(searchTerm.toLowerCase()))
      : users;
    setFilteredUsers(filteredUsers);
  }, [searchTerm, users]);

  const closeModal = () => {
    setNewUser({
      name: '',
      last_name: '',
      dni: '',
      email: '',
      password: '',
      points: '',
    });
    setIsModalOpen(false);
    setSelectedUserId(null);
  };

  const handleUpdateUser = () => {
    const token = localStorage.getItem('token');
  
    fetch(`http://127.0.0.1:8000/api/users/${selectedUserId}`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(newUser),
    })
      .then(response => response.json())
      .then(data => {
        // Update local state only after a successful API response
        fetch('http://127.0.0.1:8000/api/users', {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${token}`,
          },
        })
          .then(response => response.json())
          .then(updatedUsers => setUsers(updatedUsers))
          .catch(error => console.error('Error fetching users after update:', error));
  
        setNewUser({
          name: '',
          last_name: '',
          dni: '',
          email: '',
          password: '',
          points: '',
        });
        setIsModalOpen(false);
        setSelectedUserId(null);
      })
      .catch(error => console.error('Error updating user:', error));
  };
  
  
  

  const handleDeleteUser = (userId) => {
    Swal.fire({
      title: '¿Borrar usuario?',
      text: 'No podrás revertir esto.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'SI',
      cancelButtonText: 'NO'
    }).then((result) => {
      if (result.isConfirmed) {
        const token = localStorage.getItem('token');
  
        fetch(`http://127.0.0.1:8000/api/users/${userId}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${token}`,
          },
        })
          .then(() => {
            setUsers(users.filter(user => user.id !== userId));
          })
          .catch(error => console.error('Error deleting user:', error));
        
        Swal.fire(
          '¡Borrado!',
          'El usuario ha sido eliminado.',
          'success'
        );
      }
    });
  };
  

  return (
    <div>
      {/* Navbar */}
      <div className="bg-gray-800 text-white p-4 flex justify-between items-center">
        <h1 className="text-2xl font-bold">Sistema de administración de usuarios</h1>
        <button onClick={handleLogout}>Cerrar sesión</button>
      </div>

      {/* Create User Button */}
      <input
  type="text"
  placeholder="Buscar usuarios por RUT/DNI"
  value={searchTerm}
  onChange={(e) => setSearchTerm(e.target.value)}
  className="p-2 border border-gray-300 rounded mb-4 w-full"
/>


  <table className="border w-full">
    <thead>
      <tr>
        <th className="border px-4 py-2">Name</th>
        <th className="border px-4 py-2">Last Name</th>
        <th className="border px-4 py-2">DNI</th>
        <th className="border px-4 py-2">Email</th>
        <th className="border px-4 py-2">Points</th>
        <th className="border px-4 py-2">
          <button
            onClick={() => setIsModalOpen(true)}
            className="bg-blue-500 text-white py-2 px-4 rounded"
          >
            Crear usuario
          </button>
        </th>
      </tr>
    </thead>
    <tbody>
  {filteredUsers.map((user) => (
    <tr key={user.id}>
      <td className="border px-4 py-2">{user.name}</td>
      <td className="border px-4 py-2">{user.last_name}</td>
      <td className="border px-4 py-2">{user.dni}</td>
      <td className="border px-4 py-2">{user.email}</td>
      <td className="border px-4 py-2">{user.points}</td>
      <td className="border px-4 py-2 flex items-center justify-center space-x-2">
        <button onClick={() => { setIsModalOpen(true); setSelectedUserId(user.id); }}>
          <i className="fas fa-pencil-alt"></i>
        </button>
        <button onClick={() => handleDeleteUser(user.id)}>
          <i className="fas fa-trash"></i>
        </button>
      </td>
    </tr>
  ))}
</tbody>
  </table>

      {/* Create/Edit User Modal */}
      <Modal isOpen={isModalOpen} onRequestClose={(closeModal) => { setIsModalOpen(false); setSelectedUserId(null); }}>
  <h2 className="text-3xl font-bold text-center mb-4">{selectedUserId ? 'Editar Usuario' : 'Crear Usuario'}</h2>
  <div className="flex flex-col items-center">
    <input
      type="text"
      placeholder="Nombre"
      value={newUser.name}
      onChange={(e) => setNewUser({ ...newUser, name: e.target.value })}
      className="mb-2 p-2 border border-gray-300 rounded w-3/4 max-w-sm"
    />
    <input
      type="text"
      placeholder="Apellido"
      value={newUser.last_name}
      onChange={(e) => setNewUser({ ...newUser, last_name: e.target.value })}
      className="mb-2 p-2 border border-gray-300 rounded w-3/4 max-w-sm"
    />
    <input
      type="text"
      placeholder="DNI"
      value={newUser.dni}
      onChange={(e) => setNewUser({ ...newUser, dni: e.target.value })}
      className="mb-2 p-2 border border-gray-300 rounded w-3/4 max-w-sm"
    />
    <input
      type="email"
      placeholder="Correo electrónico"
      value={newUser.email}
      onChange={(e) => setNewUser({ ...newUser, email: e.target.value })}
      pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
      required
      className="mb-2 p-2 border border-gray-300 rounded w-3/4 max-w-sm"
    />
    <input
      type="password"
      placeholder="Contraseña"
      value={newUser.password}
      onChange={(e) => setNewUser({ ...newUser, password: e.target.value })}
      className="mb-2 p-2 border border-gray-300 rounded w-3/4 max-w-sm"
    />
    <input
      type="number"
      placeholder="Puntos"
      value={newUser.points}
      onChange={(e) => setNewUser({ ...newUser, points: e.target.value })}
      className="mb-2 p-2 border border-gray-300 rounded w-3/4 max-w-sm"
    />
  </div>
  <div className="flex justify-center mt-4">
    <button onClick={selectedUserId ? handleUpdateUser : handleCreateUser} className="bg-blue-500 text-white py-2 px-4 rounded mr-2">
      {selectedUserId ? 'Actualizar Usuario' : 'Crear Usuario'}
    </button>
    <button onClick={() => { closeModal(); setIsModalOpen(false); setSelectedUserId(null); }} className="bg-gray-500 text-white py-2 px-4 rounded">
      Cancelar
    </button>
  </div>
</Modal>


    </div>
  );
};

export default Users;
