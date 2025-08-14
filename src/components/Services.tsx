import { useState, useEffect } from "react";
import { Code, Wrench, Plus, Bug } from "lucide-react";
import { servicesService } from "@/services/backendApi";

const Services = () => {
  const [services, setServices] = useState<any[]>([]);
  
  const [loading, setLoading] = useState(true);
  
  useEffect(() => {
    const fetchServices = async () => {
      try {
        const response = await servicesService.getActiveServices();
        if (response.success) {
          // Map the API data to the component structure
          const mappedServices = response.services.map((service: any) => {
            // Map icon names to actual icon components
            let iconComponent = Code;
            switch (service.icon) {
              case 'Wrench':
                iconComponent = Wrench;
                break;
              case 'Plus':
                iconComponent = Plus;
                break;
              case 'Bug':
                iconComponent = Bug;
                break;
              default:
                iconComponent = Code;
            }
            
            return {
              id: service.id,
              icon: iconComponent,
              title: service.name,
              description: service.short_description || service.description,
              features: service.features || [],
              color: service.color || 'blue'
            };
          });
          
          setServices(mappedServices);
        }
      } catch (error) {
        console.error('Failed to fetch services:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchServices();
  }, []);

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
          {loading && (
            <div className="col-span-full text-center text-gray-500">Memuat layanan...</div>
          )}
          {!loading && services.length === 0 && (
            <div className="col-span-full text-center text-gray-500">Belum ada layanan yang tersedia.</div>
          )}
          {!loading && services.map((service, index) => {
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