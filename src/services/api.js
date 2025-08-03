// API service untuk integrasi React dengan backend PHP
const API_BASE_URL = 'http://localhost/company_profile_syntaxtrust/backend/api';

class ApiService {
    constructor() {
        this.baseURL = API_BASE_URL;
    }

    // Helper untuk handle response
    async handleResponse(response) {
        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Something went wrong');
        }
        return response.json();
    }

    // Login
    async login(email, password) {
        try {
            const response = await fetch(`${this.baseURL}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
                credentials: 'include' // Important for session cookies
            });
            return this.handleResponse(response);
        } catch (error) {
            throw new Error('Login failed: ' + error.message);
        }
    }

    // Check auth status
    async checkAuthStatus() {
        try {
            const response = await fetch(`${this.baseURL}/auth/status`, {
                credentials: 'include'
            });
            return this.handleResponse(response);
        } catch (error) {
            return { authenticated: false };
        }
    }

    // Logout
    async logout() {
        try {
            const response = await fetch(`${this.baseURL}/auth/logout`, {
                method: 'DELETE',
                credentials: 'include'
            });
            return this.handleResponse(response);
        } catch (error) {
            throw new Error('Logout failed: ' + error.message);
        }
    }

    // Get current user info
    async getCurrentUser() {
        try {
            const response = await fetch(`${this.baseURL}/auth/user`, {
                credentials: 'include'
            });
            return this.handleResponse(response);
        } catch (error) {
            throw new Error('Failed to get user info: ' + error.message);
        }
    }

    // Get portfolio items
    async getPortfolio() {
        try {
            const response = await fetch(`${this.baseURL}/portfolio`);
            return this.handleResponse(response);
        } catch (error) {
            throw new Error('Failed to get portfolio: ' + error.message);
        }
    }

    // Get users
    async getUsers() {
        try {
            const response = await fetch(`${this.baseURL}/users`);
            return this.handleResponse(response);
        } catch (error) {
            throw new Error('Failed to get users: ' + error.message);
        }
    }
}

// Create singleton instance
const apiService = new ApiService();

// Export for use in React components
export default apiService;

// Named exports for specific functions
export const {
    login,
    checkAuthStatus,
    logout,
    getCurrentUser,
    getPortfolio,
    getUsers
} = apiService;
