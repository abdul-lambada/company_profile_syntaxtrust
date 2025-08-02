import { useLocation } from "react-router-dom";
import { useEffect } from "react";
import { Button } from "@/components/ui/button";
import { Home, ArrowLeft } from "lucide-react";

const NotFound = () => {
  const location = useLocation();

  useEffect(() => {
    console.error(
      "404 Error: User attempted to access non-existent route:",
      location.pathname
    );
  }, [location.pathname]);

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
      <div className="text-center max-w-md mx-auto px-6">
        <div className="mb-8">
          <div className="w-32 h-32 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-6">
            <span className="text-6xl font-bold text-purple-600">404</span>
          </div>
        </div>
        
        <h1 className="text-4xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h1>
        <p className="text-xl text-gray-600 mb-8">
          Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.
        </p>
        
        <div className="space-y-4">
          <Button 
            onClick={() => window.history.back()}
            variant="outline" 
            className="border-purple-200 text-purple-700 hover:bg-purple-50"
          >
            <ArrowLeft className="w-4 h-4 mr-2" />
            Kembali
          </Button>
          
          <Button 
            onClick={() => window.location.href = '/'}
            className="bg-purple-600 hover:bg-purple-700"
          >
            <Home className="w-4 h-4 mr-2" />
            Kembali ke Beranda
          </Button>
        </div>
        
        <div className="mt-8 p-4 bg-white rounded-lg border border-gray-200">
          <p className="text-sm text-gray-500">
            URL yang dicoba: <code className="bg-gray-100 px-2 py-1 rounded text-xs">{location.pathname}</code>
          </p>
        </div>
      </div>
    </div>
  );
};

export default NotFound;
