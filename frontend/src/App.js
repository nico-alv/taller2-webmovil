import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'; // Change here
import './App.css';
import Login from './Login';
import Users from './Users';

const App = () => {
  return (
    <Router>
      <Routes> {/* Change here */}
        <Route path="/" element={<Login />} />
        <Route path="/users" element={<Users />} />
      </Routes> {/* Change here */}
    </Router>
  );
};

export default App;
