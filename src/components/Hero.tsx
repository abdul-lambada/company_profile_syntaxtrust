import { Button } from "@/components/ui/button";
import { ArrowRight, Code, Sparkles } from "lucide-react";

const Hero = () => {
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
            Website profesional dengan harga mahasiswa! Perfect untuk tugas kuliah, portfolio, bisnis kecil, dan startup dengan budget terbatas.
          </p>
        </div>

        {/* CTA Buttons */}
        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-up" style={{animationDelay: '0.4s'}}>
          <Button variant="default" size="lg" className="group bg-white text-blue-600 hover:bg-gray-100 shadow-xl font-semibold">
            <Sparkles className="w-5 h-5" />
            Mulai Proyek Anda
            <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
          </Button>
          <Button variant="outline" size="lg" className="border-white/30 text-white hover:bg-white/10 bg-white/5 backdrop-blur-sm">
            Lihat Portfolio
          </Button>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 animate-fade-up" style={{animationDelay: '0.6s'}}>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">200+</div>
            <div className="text-gray-700">Mahasiswa Puas</div>
          </div>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">80+</div>
            <div className="text-gray-700">Bisnis Kecil</div>
          </div>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">Mulai</div>
            <div className="text-gray-700">Rp 299K</div>
          </div>
          <div className="glass-card text-center bg-white/95 backdrop-blur-sm border border-white/20 shadow-xl">
            <div className="text-3xl font-bold text-blue-600 mb-2">3-7</div>
            <div className="text-gray-700">Hari Selesai</div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;