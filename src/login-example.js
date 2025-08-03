// Contoh fetch login dari frontend (React/Vue/JS)
// Pastikan jalankan dari http://localhost:8080 (Vite)

export async function login(email, password) {
  const response = await fetch('http://localhost/company_profile_syntaxtrust/backend/api.php/users/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ email, password }),
    credentials: 'include', // penting agar session PHP tetap terhubung
  });
  const data = await response.json();
  return data;
}

// Contoh penggunaan:
// login('user@example.com', 'password123').then(console.log);
