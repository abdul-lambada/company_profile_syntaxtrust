import { Code, Wrench, Plus, Bug } from "lucide-react";

const Services = () => {
  const services = [
    {
      icon: Code,
      title: "Pembuatan Website Baru",
      description: "Desain modern dengan performa tinggi dan responsif di semua perangkat",
      features: ["Responsive Design", "SEO Optimized", "Fast Loading", "Modern UI/UX"]
    },
    {
      icon: Wrench,
      title: "Modifikasi & Peningkatan",
      description: "Pembaruan fitur dan tampilan untuk meningkatkan performa website",
      features: ["UI/UX Improvement", "Performance Boost", "Security Update", "Feature Enhancement"]
    },
    {
      icon: Plus,
      title: "Penambahan Fitur Kustom",
      description: "Solusi sesuai kebutuhan spesifik bisnis Anda",
      features: ["Custom Features", "Third-party Integration", "API Development", "Database Design"]
    },
    {
      icon: Bug,
      title: "Debugging & Perbaikan Bug",
      description: "Solusi masalah dengan cepat dan efisien",
      features: ["Bug Fixing", "Error Resolution", "Code Optimization", "24/7 Support"]
    }
  ];

  return (
    <section id="services" className="py-20 bg-gradient-to-br from-gray-50 to-white">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
            <span className="w-2 h-2 bg-primary rounded-full"></span>
            Layanan Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Solusi Digital Terlengkap
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Kami menyediakan layanan web development yang komprehensif untuk memenuhi semua kebutuhan digital bisnis Anda
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {services.map((service, index) => (
            <div
              key={index}
              className="group p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100"
            >
              <div className="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                <service.icon className="w-8 h-8 text-primary group-hover:text-white transition-colors duration-300" />
              </div>
              
              <h3 className="text-xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors duration-300">
                {service.title}
              </h3>
              
              <p className="text-gray-600 mb-6 leading-relaxed">
                {service.description}
              </p>

              <ul className="space-y-2">
                {service.features.map((feature, idx) => (
                  <li key={idx} className="flex items-center text-sm text-gray-600">
                    <span className="w-1.5 h-1.5 bg-primary rounded-full mr-3"></span>
                    {feature}
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Services;