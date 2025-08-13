import React, { useEffect } from 'react';

// Komponen ini akan langsung redirect ke halaman login backend PHP
const LoginRedirect = () => {
  useEffect(() => {
    window.location.href =
      'http://localhost/company_profile_syntaxtrust/backend/login.php';
  }, []);

  return (
    <div style={{ textAlign: 'center', marginTop: '100px' }}>
      <h2>Mengalihkan ke halaman login...</h2>
      <p>Jika tidak otomatis, <a href="http://localhost/company_profile_syntaxtrust/backend/login.php">klik di sini</a>.</p>
    </div>
  );
};

export default LoginRedirect;
