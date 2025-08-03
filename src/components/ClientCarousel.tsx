import { useEffect, useState } from "react";
import LazyImage from "./LazyImage";
import { clientsService } from "@/services/backendApi";

const ClientCarousel = () => {
  const [currentIndex, setCurrentIndex] = useState(0);
  const [clients, setClients] = useState([
    {
      name: "Mahasiswa IT",
      logo: "https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=150&h=80&fit=crop&crop=center",
      category: "Tugas Kuliah"
    },
    {
      name: "Mahasiswa Desain",
      logo: "https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=150&h=80&fit=crop&crop=center",
      category: "Portfolio"
    },
    {
      name: "UMKM Makanan",
      logo: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=150&h=80&fit=crop&crop=center",
      category: "Bisnis Kecil"
    },
    {
      name: "Mahasiswa Bisnis",
      logo: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=150&h=80&fit=crop&crop=center",
      category: "Project Akhir"
    },
    {
      name: "Toko Online",
      logo: "https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=150&h=80&fit=crop&crop=center",
      category: "E-commerce"
    },
    {
      name: "Bisnis Kafe",
      logo: "https://images.unsplash.com/photo-1554224155-165aa83f6b3a?w=150&h=80&fit=crop&crop=center",
      category: "Bisnis Kecil"
    },
    {
      name: "Mahasiswa TI",
      logo: "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=150&h=80&fit=crop&crop=center",
      category: "Tugas Kuliah"
    },
    {
      name: "Startup Tech",
      logo: "https://images.unsplash.com/photo-1551284184-9d8d167c1ef3?w=150&h=80&fit=crop&crop=center",
      category: "Startup"
    }
  ]);
  
  const [loading, setLoading] = useState(true);
  
  useEffect(() => {
    const fetchClients = async () => {
      try {
        const response = await clientsService.getActiveClients();
        if (response.success) {
          // Map the API data to the component structure
          const mappedClients = response.clients.map((client: any) => ({
            id: client.id,
            name: client.name,
            logo: client.logo || `https://images.unsplash.com/photo-${client.id}?w=150&h=80&fit=crop&crop=center`,
            category: client.category || "Client"
          }));
          
          setClients(mappedClients);
        }
      } catch (error) {
        console.error('Failed to fetch clients:', error);
        // Keep using the hardcoded data if API fails
      } finally {
        setLoading(false);
      }
    };
    
    fetchClients();
  }, []);

  // Auto-scroll effect
  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentIndex((prevIndex) => (prevIndex + 1) % clients.length);
    }, 3000); // Change every 3 seconds

    return () => clearInterval(interval);
  }, [clients.length]);

  // Duplicate clients for seamless loop
  const duplicatedClients = [...clients, ...clients];

  return (
    <section className="py-16 bg-gray-50">
      <div className="container mx-auto px-6">
        <div className="text-center mb-12">
          <div className="inline-flex items-center gap-2 bg-purple-600/10 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 border border-purple-200">
            <span className="w-2 h-2 bg-purple-600 rounded-full"></span>
            Klien Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Dipercaya oleh Mahasiswa & Bisnis Kecil
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Kami telah membantu ratusan mahasiswa dan bisnis kecil mewujudkan website profesional dengan harga terjangkau
          </p>
        </div>

        {/* Carousel Container */}
        <div className="relative overflow-hidden">
          <div className="flex items-center justify-center">
            {/* Carousel Track */}
            <div 
              className="flex transition-transform duration-1000 ease-in-out"
              style={{
                transform: `translateX(-${(currentIndex * 100) / clients.length}%)`,
                width: `${(duplicatedClients.length * 100) / 4}%` // Show 4 items at a time
              }}
            >
              {duplicatedClients.map((client, index) => (
                <div
                  key={index}
                  className="flex-shrink-0 w-1/4 px-4"
                >
                  <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-200">
                    <div className="flex flex-col items-center">
                      <div className="w-20 h-20 mb-4 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                        <LazyImage
                          src={client.logo}
                          alt={client.name}
                          className="w-full h-full"
                        />
                      </div>
                      <h3 className="text-lg font-semibold text-gray-800 mb-2 text-center">
                        {client.name}
                      </h3>
                      <p className="text-sm text-gray-600 text-center">
                        {client.category}
                      </p>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* Navigation Dots */}
          <div className="flex justify-center mt-8 space-x-2">
            {clients.map((_, index) => (
              <button
                key={index}
                onClick={() => setCurrentIndex(index)}
                className={`w-3 h-3 rounded-full transition-all duration-300 ${
                  index === currentIndex
                    ? "bg-purple-600 w-8"
                    : "bg-gray-300 hover:bg-gray-400"
                }`}
              />
            ))}
          </div>

          {/* Navigation Arrows */}
          <button
            onClick={() => setCurrentIndex((prev) => (prev - 1 + clients.length) % clients.length)}
            className="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors duration-300 border border-gray-200"
          >
            <svg className="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          
          <button
            onClick={() => setCurrentIndex((prev) => (prev + 1) % clients.length)}
            className="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors duration-300 border border-gray-200"
          >
            <svg className="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>

        {/* Stats Section */}
        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="text-center">
            <div className="text-4xl font-bold text-purple-600 mb-2">200+</div>
            <div className="text-gray-600">Mahasiswa Puas</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-purple-600 mb-2">80+</div>
            <div className="text-gray-600">Bisnis Kecil</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-purple-600 mb-2">99%</div>
            <div className="text-gray-600">Tingkat Kepuasan</div>
          </div>
        </div>

        {/* CTA Section */}
        <div className="mt-16 text-center">
          <div className="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-8 text-white shadow-xl">
            <h3 className="text-2xl md:text-3xl font-bold mb-4">
              Bergabung dengan Mahasiswa & Bisnis Terpercaya Kami
            </h3>
            <p className="text-lg mb-6 opacity-90">
              Mari wujudkan website profesional untuk tugas kuliah atau bisnis kecil Anda dengan harga terjangkau
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <button className="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-300">
                Konsultasi Gratis
              </button>
              <button className="bg-white/10 border border-white/20 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/20 transition-colors duration-300">
                Lihat Portfolio
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default ClientCarousel; 