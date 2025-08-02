import { Code, Wrench, Plus, Bug } from "lucide-react";

const Services = () => {
  const services = [
    {
      icon: Code,
      title: "Website Portfolio",
      description: "Portfolio profesional untuk tugas kuliah, magang, dan karir masa depan",
      features: ["Responsive Design", "SEO Optimized", "Fast Loading", "Modern UI/UX"],
      color: "blue"
    },
    {
      icon: Wrench,
      title: "Website Bisnis Kecil",
      description: "Website sederhana untuk UMKM, toko online, dan bisnis lokal",
      features: ["UI/UX Improvement", "Performance Boost", "Security Update", "Feature Enhancement"],
      color: "green"
    },
    {
      icon: Plus,
      title: "Website Tugas Kuliah",
      description: "Website untuk tugas mata kuliah, project akhir, dan penelitian",
      features: ["Custom Features", "Third-party Integration", "API Development", "Database Design"],
      color: "purple"
    },
    {
      icon: Bug,
      title: "Perbaikan & Maintenance",
      description: "Perbaikan bug, update fitur, dan maintenance website existing",
      features: ["Bug Fixing", "Error Resolution", "Code Optimization", "WhatsApp Support"],
      color: "orange"
    }
  ];

  const getColorClasses = (color: string) => {
    const colors = {
      blue: {
        bg: "bg-blue-100",
        text: "text-blue-700",
        hover: "group-hover:bg-blue-600",
        icon: "text-blue-600",
        iconHover: "group-hover:text-white",
        dot: "bg-blue-600"
      },
      green: {
        bg: "bg-green-100",
        text: "text-green-700",
        hover: "group-hover:bg-green-600",
        icon: "text-green-600",
        iconHover: "group-hover:text-white",
        dot: "bg-green-600"
      },
      purple: {
        bg: "bg-purple-100",
        text: "text-purple-700",
        hover: "group-hover:bg-purple-600",
        icon: "text-purple-600",
        iconHover: "group-hover:text-white",
        dot: "bg-purple-600"
      },
      orange: {
        bg: "bg-orange-100",
        text: "text-orange-700",
        hover: "group-hover:bg-orange-600",
        icon: "text-orange-600",
        iconHover: "group-hover:text-white",
        dot: "bg-orange-600"
      }
    };
    return colors[color as keyof typeof colors];
  };

  return (
    <section id="services" className="py-20 bg-white">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-purple-600/10 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 border border-purple-200">
            <span className="w-2 h-2 bg-purple-600 rounded-full"></span>
            Layanan Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Layanan Terjangkau untuk Mahasiswa & Bisnis
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Website profesional dengan harga mahasiswa! Perfect untuk tugas kuliah, portfolio, dan bisnis kecil dengan budget terbatas
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {services.map((service, index) => {
            const colors = getColorClasses(service.color);
            return (
              <div
                key={index}
                className="group p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-200"
              >
                <div className={`w-16 h-16 ${colors.bg} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300 ${colors.hover}`}>
                  <service.icon className={`w-8 h-8 transition-colors duration-300 ${colors.icon} ${colors.iconHover}`} />
                </div>
                
                <h3 className="text-xl font-bold text-gray-800 mb-4 group-hover:text-gray-900 transition-colors duration-300">
                  {service.title}
                </h3>
                
                <p className="text-gray-600 mb-6 leading-relaxed">
                  {service.description}
                </p>

                <ul className="space-y-2">
                  {service.features.map((feature, idx) => (
                    <li key={idx} className="flex items-center text-sm text-gray-600">
                      <span className={`w-1.5 h-1.5 rounded-full mr-3 ${colors.dot}`}></span>
                      {feature}
                    </li>
                  ))}
                </ul>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default Services;