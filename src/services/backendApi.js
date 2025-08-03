import axios from 'axios';

const API_BASE_URL = 'http://localhost/company_profile_syntaxtrust/backend_new/api';

// Create axios instance with default config
const api = axios.create({
  baseURL: API_BASE_URL,
  withCredentials: true, // Important for session-based auth
  headers: {
    'Content-Type': 'application/json',
  }
});

// Auth service
export const authService = {
  // Login user
  login: async (email, password) => {
    try {
      const response = await api.post('/auth.php', { email, password });
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  },

  // Check authentication status
  checkAuth: async () => {
    try {
      const response = await api.get('/auth.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  },

  // Logout user
  logout: async () => {
    try {
      const response = await api.delete('/auth.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Users service
export const userService = {
  // Get all users
  getUsers: async () => {
    try {
      const response = await api.get('/users.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  },

  // Create new user
  createUser: async (userData) => {
    try {
      const response = await api.post('/users.php', userData);
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  },

  // Update user
  updateUser: async (userData) => {
    try {
      const response = await api.put('/users.php', userData);
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  },

  // Delete user
  deleteUser: async (userId) => {
    try {
      const response = await api.delete('/users.php', { data: { id: userId } });
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Request interceptor for handling common errors
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Handle unauthorized access
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export default api;
