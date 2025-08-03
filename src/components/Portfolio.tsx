import { useState, useEffect } from "react";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { ExternalLink, Code, Smartphone, ShoppingCart, Users } from "lucide-react";
import LazyImage from "./LazyImage";
import { portfolioService } from "@/services/backendApi";

const Portfolio = () => {
  const [projects, setProjects] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProjects = async () => {
      try {
        const response = await portfolioService.getActivePortfolio();
        if (response.success) {
          const mappedProjects = response.portfolio.map((project: any) => {
            let iconComponent = Code;
            switch (project.icon) {
              case 'ShoppingCart':
                iconComponent = ShoppingCart;
                break;
              case 'Smartphone':
                iconComponent = Smartphone;
                break;
              case 'Users':
                iconComponent = Users;
                break;
              default:
                iconComponent = Code;
            }
            
            return {
              id: project.id,
              title: project.title,
              description: project.description,
              image: project.image || `https://images.unsplash.com/photo-${project.id}?w=500&h=300&fit=crop`,
              technologies: project.technologies || [],
              category: project.category || "Project",
              icon: iconComponent,
              color: project.color || "bg-blue-600"
            };
          });
          
          setProjects(mappedProjects);
        }
      } catch (error) {
        console.error('Failed to fetch portfolio projects:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchProjects();
  }, []);

  return (
    <section id="portfolio" className="py-20 bg-gray-50">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-purple-600/10 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 border border-purple-200">
            <span className="w-2 h-2 bg-purple-600 rounded-full"></span>
            Portfolio Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Portfolio Mahasiswa & Bisnis Kecil
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Lihat berbagai proyek website yang telah kami kerjakan untuk mahasiswa dan bisnis kecil dengan harga terjangkau
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
          {projects.map((project, index) => (
            <Card key={index} className="group overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-200 shadow-lg bg-white">
              <div className="relative overflow-hidden">
                <LazyImage 
                  src={project.image} 
                  alt={project.title}
                  className="w-full h-48 group-hover:scale-110 transition-transform duration-300"
                />
                <div className="absolute top-4 left-4">
                  <div className={`${project.color} text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-2 shadow-md`}>
                    <project.icon className="w-4 h-4" />
                    {project.category}
                  </div>
                </div>
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div className="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <Button variant="default" size="sm" className="bg-white text-gray-800 hover:bg-gray-100">
                    <ExternalLink className="w-4 h-4" />
                    Lihat Detail
                  </Button>
                </div>
              </div>
              
              <div className="p-6">
                <h3 className="text-xl font-bold text-gray-800 mb-3 group-hover:text-gray-900 transition-colors duration-300">
                  {project.title}
                </h3>
                
                <p className="text-gray-600 mb-4 leading-relaxed">
                  {project.description}
                </p>

                <div className="flex flex-wrap gap-2">
                  {project.technologies.map((tech, idx) => (
                    <span 
                      key={idx}
                      className="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium hover:bg-blue-600 hover:text-white transition-colors duration-200 cursor-default"
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
          <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-white shadow-xl">
            <h3 className="text-2xl md:text-3xl font-bold mb-4">
              Siap Memulai Proyek Anda?
            </h3>
            <p className="text-lg mb-6 opacity-90">
              Mari diskusikan ide Anda dan wujudkan menjadi kenyataan digital yang menakjubkan
            </p>
            <Button variant="default" size="lg" className="bg-white text-blue-600 hover:bg-gray-100">
              Konsultasi Gratis Sekarang
            </Button>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Portfolio;