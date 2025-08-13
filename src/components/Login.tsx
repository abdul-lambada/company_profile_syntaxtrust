import React, { useState, useEffect } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Loader2, Server, AlertCircle, CheckCircle } from 'lucide-react';

const Login = () => {
  const [formData, setFormData] = useState({
    email: '',
    password: ''
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [serverStatus, setServerStatus] = useState<'checking' | 'online' | 'offline'>('checking');

  useEffect(() => {
    const checkServer = async () => {
      try {
        const response = await fetch('/api/auth.php', {
          method: 'GET',
          credentials: 'include',
        });
        // Server is up if we get any response, even an error like 401/405
        if (response.status > 0) {
          setServerStatus('online');
        } else {
          setServerStatus('offline');
        }
      } catch (err) {
        setServerStatus('offline');
      }
    };

    checkServer();
  }, []);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (serverStatus !== 'online') {
        setError('Cannot login while server is offline.');
        return;
    }
    setLoading(true);
    setError('');

    try {
      const response = await fetch('/api/auth.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: formData.email,
          password: formData.password
        }),
        credentials: 'include'
      });

      const data = await response.json();

      if (response.ok && data.success) {
        window.location.href = 'http://localhost/company_profile_syntaxtrust/backend/index.php';
      } else {
        setError(data.error || 'Login failed. Please check your credentials.');
      }
    } catch (err) {
      setError('A network error occurred. The server might be down.');
      console.error('Login error:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const isFormDisabled = loading || serverStatus !== 'online';

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
      <Card className="w-full max-w-md">
        <CardHeader className="space-y-1">
          <CardTitle className="text-2xl font-bold text-center">Admin Login</CardTitle>
          <CardDescription className="text-center">
            Enter your credentials to access the admin dashboard
          </CardDescription>
        </CardHeader>
        <form onSubmit={handleSubmit}>
          <CardContent className="space-y-4">
            {serverStatus === 'checking' && (
                <Alert className="bg-blue-50 border-blue-200">
                    <Loader2 className="h-4 w-4 animate-spin" />
                    <AlertTitle>Checking Server Status...</AlertTitle>
                </Alert>
            )}
            {serverStatus === 'online' && (
                <Alert variant="default" className="bg-green-50 border-green-200 text-green-800">
                    <CheckCircle className="h-4 w-4" />
                    <AlertTitle>Server is Online</AlertTitle>
                </Alert>
            )}
            {error && (
              <Alert variant="destructive">
                <AlertCircle className="h-4 w-4" />
                <AlertTitle>Error</AlertTitle>
                <AlertDescription>{error}</AlertDescription>
              </Alert>
            )}
            
            <div className="space-y-2">
              <Label htmlFor="email">Email</Label>
              <Input
                id="email"
                name="email"
                type="email"
                placeholder="admin@syntaxtrust.com"
                value={formData.email}
                onChange={handleChange}
                required
                disabled={isFormDisabled}
              />
            </div>
            
            <div className="space-y-2">
              <Label htmlFor="password">Password</Label>
              <Input
                id="password"
                name="password"
                type="password"
                placeholder="Enter your password"
                value={formData.password}
                onChange={handleChange}
                required
                disabled={isFormDisabled}
              />
            </div>
          </CardContent>
          
          <CardFooter>
            <Button 
              type="submit" 
              className="w-full" 
              disabled={isFormDisabled}
            >
              {loading ? (
                <>
                  <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                  Signing in...
                </>
              ) : (
                'Sign In'
              )}
            </Button>
          </CardFooter>
        </form>
        {serverStatus === 'offline' && (
            <CardContent>
                 <Alert variant="destructive">
                    <AlertCircle className="h-4 w-4" />
                    <AlertTitle>Server is Offline</AlertTitle>
                    <AlertDescription className="mt-2">
                        <p className="font-semibold">Could not connect to the backend server.</p>
                        <p className="mt-1">Please follow these troubleshooting steps:</p>
                        <ul className="list-disc list-inside mt-2 space-y-1 text-sm">
                            <li>Ensure <strong>XAMPP</strong> is running.</li>
                            <li>Check that both <strong>Apache</strong> and <strong>MySQL</strong> services are started.</li>
                            <li>Verify the project is in the correct <code>htdocs</code> folder.</li>
                            <li>Check for firewall or antivirus software blocking the connection.</li>
                        </ul>
                    </AlertDescription>
                </Alert>
            </CardContent>
        )}
      </Card>
    </div>
  );
};

export default Login;
