import { useState, useEffect } from "react";
import { Button } from "@/components/ui/button";
import { ArrowRight, Code, Sparkles } from "lucide-react";
import { settingsService } from "@/services/backendApi";

const Hero = () => {
  const [stats, setStats] = useState({
    students: "",
    businesses: "",
    price: "",
    delivery: ""
  });
  
  const [loading, setLoading] = useState(true);
  
  useEffect(() => {
    const fetchSettings = async () => {
      try {
        const response = await settingsService.getAllSettings();
        if (response.success && Array.isArray(response.settings)) {
          // Extract statistics from settings
          const heroStats = {
            students: response.settings.find((s: any) => s.setting_key === 'hero_students_count')?.setting_value || "",
            businesses: response.settings.find((s: any) => s.setting_key === 'hero_businesses_count')?.setting_value || "",
            price: response.settings.find((s: any) => s.setting_key === 'hero_price_text')?.setting_value || "",
            delivery: response.settings.find((s: any) => s.setting_key === 'hero_delivery_time')?.setting_value || ""
          };
          
          setStats(heroStats);
        }
      } catch (error) {
        console.error('Failed to fetch hero statistics:', error);
        // Keep using the hardcoded data if API fails
      } finally {
        setLoading(false);
      }
    };
    
    fetchSettings();
  }, []);
  
  return (
    <section className="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700">
      {/* Floating decorative elements */}
      <div className="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-float"></div>
      <div className="absolute bottom-20 right-10 w-32 h-32 bg-white/8 rounded-full blur-2xl animate-float" style={{animationDelay: '2s'}}></div>
      <div className="absolute top-1/2 left-1/4 w-16 h-16 bg-white/10 rounded-full blur-lg animate-float" style={{animationDelay: '4s'}}></div>
      
      <div className="container mx-auto px-6 text-center relative z-10">
        {/* Logo */}
        {/* <div className="mb-8 animate-bounce-in">
          <div className="w-24 h-24 mx-auto bg-white/95 rounded-full flex items-center justify-center shadow-xl">
            <Code className="w-12 h-12 text-blue-600" />
          </div>
        </div> */}

        {/* Main Heading */}
        <div className="animate-fade-up" style={{animationDelay: '0.2s'}}>
          <h1 className="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
            Solusi Digital{" "}
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-100">
              Terjangkau
            </span>{" "}
            untuk Mahasiswa & Bisnis!
          </h1>
          
          <p className="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
            Jasa pembuatan website profesional dengan harga terjangkau khusus untuk mahasiswa dan bisnis kecil. 
            Dapatkan website modern, responsif, dan siap pakai dalam hitungan hari!
          </p>
        </div>

        {/* CTA Button */}
        <div className="animate-fade-up mb-16" style={{animationDelay: '0.4s'}}>
          <Button 
            size="lg" 
            className="bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-6 rounded-full font-semibold shadow-xl hover:shadow-2xl transition-all duration-300 group"
            onClick={() => {
              const element = document.getElementById('contact');
              if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
              }
            }}
          >
            Mulai Project Sekarang
            <ArrowRight className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" />
          </Button>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto animate-fade-up" style={{animationDelay: '0.6s'}}>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">{stats.students || (loading ? '...' : '')}</div>
            <div className="text-gray-700">Mahasiswa Puas</div>
          </div>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">{stats.businesses || (loading ? '...' : '')}</div>
            <div className="text-gray-700">Bisnis Kecil</div>
          </div>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">{stats.price || (loading ? '...' : '')}</div>
            <div className="text-gray-700">Harga Terjangkau</div>
          </div>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">{stats.delivery || (loading ? '...' : '')}</div>
            <div className="text-gray-700">Hari Selesai</div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;