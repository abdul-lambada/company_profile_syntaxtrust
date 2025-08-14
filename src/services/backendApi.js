import axios from 'axios';

// Prefer Vite env, fallback to Vite proxy '/api'
const envBase = import.meta?.env?.VITE_API_BASE_URL?.trim();
let API_BASE_URL = envBase && envBase.length > 0
  ? envBase
  : '/api';
// Normalize: remove trailing slash
API_BASE_URL = API_BASE_URL.replace(/\/$/, '');

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

// Settings service
export const settingsService = {
  // Get all settings
  getAllSettings: async () => {
    try {
      const response = await api.get('/settings.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  },

  // Update setting
  updateSetting: async (settingData) => {
    try {
      const response = await api.put('/settings.php', settingData);
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Services service
export const servicesService = {
  // Get all active services
  getActiveServices: async () => {
    try {
      const response = await api.get('/services.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Clients service
export const clientsService = {
  // Get all active clients
  getActiveClients: async () => {
    try {
      const response = await api.get('/clients.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Team service
export const teamService = {
  // Get all active team members
  getActiveTeam: async () => {
    try {
      const response = await api.get('/team.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Portfolio service
export const portfolioService = {
  // Get all active portfolio items
  getActivePortfolio: async () => {
    try {
      const response = await api.get('/portfolio.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Pricing plans service
export const pricingService = {
  // Get all active pricing plans
  getActivePricing: async () => {
    try {
      const response = await api.get('/pricing_plans.php');
      return response.data;
    } catch (error) {
      throw error.response?.data || error.message;
    }
  }
};

// Contact inquiries service
export const contactService = {
  // Submit contact inquiry
  submitInquiry: async (inquiryData) => {
    try {
      const response = await api.post('/contact_inquiries.php', inquiryData);
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
