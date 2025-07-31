import { Button } from "@/components/ui/button";
import { ArrowRight, Code, Sparkles } from "lucide-react";

const Hero = () => {
  return (
    <section className="min-h-screen hero-bg flex items-center justify-center relative overflow-hidden">
      {/* Floating decorative elements */}
      <div className="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-float"></div>
      <div className="absolute bottom-20 right-10 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-float" style={{animationDelay: '2s'}}></div>
      <div className="absolute top-1/2 left-1/4 w-16 h-16 bg-white/10 rounded-full blur-lg animate-float" style={{animationDelay: '4s'}}></div>
      
      <div className="container mx-auto px-6 text-center relative z-10">
        {/* Logo */}
        <div className="mb-8 animate-bounce-in">
          <div className="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-2xl">
            <Code className="w-12 h-12 text-primary" />
          </div>
        </div>

        {/* Main Heading */}
        <div className="animate-fade-up" style={{animationDelay: '0.2s'}}>
          <h1 className="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
            Wujudkan{" "}
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">
              Impian Digital
            </span>{" "}
            Anda!
          </h1>
          
          <p className="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
            Layanan profesional untuk pembuatan, modifikasi, penambahan fitur, dan debugging website Anda dengan teknologi terdepan.
          </p>
        </div>

        {/* CTA Buttons */}
        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-up" style={{animationDelay: '0.4s'}}>
          <Button variant="hero" size="lg" className="group">
            <Sparkles className="w-5 h-5" />
            Mulai Proyek Anda
            <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
          </Button>
          <Button variant="outline" size="lg">
            Lihat Portfolio
          </Button>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 animate-fade-up" style={{animationDelay: '0.6s'}}>
          <div className="glass-card text-center">
            <div className="text-3xl font-bold text-white mb-2">100+</div>
            <div className="text-white/80">Proyek Selesai</div>
          </div>
          <div className="glass-card text-center">
            <div className="text-3xl font-bold text-white mb-2">50+</div>
            <div className="text-white/80">Klien Puas</div>
          </div>
          <div className="glass-card text-center">
            <div className="text-3xl font-bold text-white mb-2">24/7</div>
            <div className="text-white/80">Support</div>
          </div>
          <div className="glass-card text-center">
            <div className="text-3xl font-bold text-white mb-2">5+</div>
            <div className="text-white/80">Tahun Pengalaman</div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;