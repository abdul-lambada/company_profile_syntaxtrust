import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { ExternalLink, Code, Smartphone, ShoppingCart, Users } from "lucide-react";

const Portfolio = () => {
  const projects = [
    {
      title: "E-Commerce Platform",
      description: "Platform e-commerce modern dengan sistem pembayaran terintegrasi dan dashboard admin yang komprehensif",
      image: "https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=500&h=300&fit=crop",
      technologies: ["Laravel", "MySQL", "Bootstrap", "PayPal API"],
      category: "E-Commerce",
      icon: ShoppingCart,
      color: "bg-green-500"
    },
    {
      title: "Mobile App Backend",
      description: "REST API untuk aplikasi mobile dengan sistem autentikasi JWT dan real-time notifications",
      image: "https://images.unsplash.com/photo-1551650975-87deedd944c3?w=500&h=300&fit=crop",
      technologies: ["PHP Native", "MySQL", "JWT", "WebSocket"],
      category: "Mobile Backend",
      icon: Smartphone,
      color: "bg-blue-500"
    },
    {
      title: "Company Profile Website",
      description: "Website company profile responsif dengan CMS untuk update konten dan optimasi SEO",
      image: "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&h=300&fit=crop",
      technologies: ["HTML5", "CSS3", "JavaScript", "PHP"],
      category: "Corporate",
      icon: Code,
      color: "bg-purple-500"
    },
    {
      title: "Community Platform",
      description: "Platform komunitas dengan fitur forum, event management, dan sistem membership",
      image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&h=300&fit=crop",
      technologies: ["CodeIgniter", "MySQL", "Bootstrap", "jQuery"],
      category: "Social Platform",
      icon: Users,
      color: "bg-orange-500"
    }
  ];

  return (
    <section id="portfolio" className="py-20 bg-white">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
            <span className="w-2 h-2 bg-primary rounded-full"></span>
            Portfolio Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Karya Digital Terbaik
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Lihat berbagai proyek yang telah kami kerjakan dengan teknologi terdepan dan hasil yang memuaskan klien
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
          {projects.map((project, index) => (
            <Card key={index} className="group overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-0 shadow-lg">
              <div className="relative overflow-hidden">
                <img 
                  src={project.image} 
                  alt={project.title}
                  className="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300"
                />
                <div className="absolute top-4 left-4">
                  <div className={`${project.color} text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-2`}>
                    <project.icon className="w-4 h-4" />
                    {project.category}
                  </div>
                </div>
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div className="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <Button variant="hero" size="sm">
                    <ExternalLink className="w-4 h-4" />
                    Lihat Detail
                  </Button>
                </div>
              </div>
              
              <div className="p-6">
                <h3 className="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300">
                  {project.title}
                </h3>
                
                <p className="text-gray-600 mb-4 leading-relaxed">
                  {project.description}
                </p>

                <div className="flex flex-wrap gap-2">
                  {project.technologies.map((tech, idx) => (
                    <span 
                      key={idx}
                      className="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium hover:bg-primary hover:text-white transition-colors duration-200 cursor-default"
                    >
                      {tech}
                    </span>
                  ))}
                </div>
              </div>
            </Card>
          ))}
        </div>

        {/* CTA Section */}
        <div className="text-center mt-16">
          <div className="bg-gradient-to-r from-primary to-purple-600 rounded-2xl p-8 text-white">
            <h3 className="text-2xl md:text-3xl font-bold mb-4">
              Siap Memulai Proyek Anda?
            </h3>
            <p className="text-lg mb-6 opacity-90">
              Mari diskusikan ide Anda dan wujudkan menjadi kenyataan digital yang menakjubkan
            </p>
            <Button variant="hero" size="lg">
              Konsultasi Gratis Sekarang
            </Button>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Portfolio;