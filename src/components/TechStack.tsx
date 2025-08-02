const TechStack = () => {
  const technologies = [
    { name: "HTML5", color: "bg-orange-500/90", textColor: "text-white" },
    { name: "CSS3", color: "bg-blue-500/90", textColor: "text-white" },
    { name: "JavaScript", color: "bg-yellow-500/90", textColor: "text-gray-800" },
    { name: "PHP", color: "bg-purple-600/90", textColor: "text-white" },
    { name: "Python", color: "bg-blue-600/90", textColor: "text-white" },
    { name: "Laravel", color: "bg-red-500/90", textColor: "text-white" },
    { name: "CodeIgniter", color: "bg-orange-600/90", textColor: "text-white" },
    { name: "Bootstrap", color: "bg-purple-700/90", textColor: "text-white" },
    { name: "Node.js", color: "bg-green-600/90", textColor: "text-white" },
    { name: "MySQL", color: "bg-blue-700/90", textColor: "text-white" },
    { name: "MongoDB", color: "bg-green-500/90", textColor: "text-white" },
    { name: "PostgreSQL", color: "bg-blue-800/90", textColor: "text-white" },
    { name: "Apache", color: "bg-red-600/90", textColor: "text-white" },
    { name: "Vercel", color: "bg-gray-800/90", textColor: "text-white" },
    { name: "React", color: "bg-blue-400/90", textColor: "text-white" },
    { name: "Vue.js", color: "bg-green-500/90", textColor: "text-white" }
  ];

  return (
    <section id="tech" className="py-20 bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
      {/* Background decorations */}
      <div className="absolute top-10 right-10 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl animate-float"></div>
      <div className="absolute bottom-10 left-10 w-24 h-24 bg-indigo-500/5 rounded-full blur-xl animate-float" style={{animationDelay: '3s'}}></div>
      
      <div className="container mx-auto px-6 relative z-10">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-purple-600/10 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 border border-purple-200">
            <span className="w-2 h-2 bg-purple-600 rounded-full"></span>
            Teknologi Unggulan
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Stack Teknologi Terdepan
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Kami menggunakan teknologi terbaru dan terpercaya untuk membangun solusi digital yang powerful, efisien, dan scalable
          </p>
        </div>

        {/* Technology Grid */}
        <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-12">
          {technologies.map((tech, index) => (
            <div
              key={index}
              className={`tech-badge ${tech.color} ${tech.textColor} hover:scale-110 hover:-translate-y-2 cursor-pointer group shadow-md hover:shadow-lg transition-all duration-300`}
              style={{animationDelay: `${index * 0.1}s`}}
            >
              <span className="font-bold text-xs md:text-sm">{tech.name}</span>
            </div>
          ))}
        </div>

        {/* Features */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
          <div className="glass-card text-center bg-white/80 backdrop-blur-sm border border-gray-200">
            <div className="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <span className="text-2xl">⚡</span>
            </div>
            <h3 className="text-xl font-bold text-gray-800 mb-3">Performa Tinggi</h3>
            <p className="text-gray-600">Pengembangan web yang kuat, efisien, dan scalable untuk semua kebutuhan bisnis</p>
          </div>
          
          <div className="glass-card text-center bg-white/80 backdrop-blur-sm border border-gray-200">
            <div className="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <span className="text-2xl">🛡️</span>
            </div>
            <h3 className="text-xl font-bold text-gray-800 mb-3">Keamanan Terjamin</h3>
            <p className="text-gray-600">Implementasi best practices dalam security untuk melindungi data dan aplikasi</p>
          </div>
          
          <div className="glass-card text-center bg-white/80 backdrop-blur-sm border border-gray-200">
            <div className="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <span className="text-2xl">🚀</span>
            </div>
            <h3 className="text-xl font-bold text-gray-800 mb-3">Deployment Mudah</h3>
            <p className="text-gray-600">Support berbagai platform hosting dan cloud services untuk deployment yang seamless</p>
          </div>
        </div>
      </div>
    </section>
  );
};

export default TechStack;