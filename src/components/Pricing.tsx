import { useState, useEffect } from "react";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Check, Star, Zap, Crown, Rocket } from "lucide-react";
import { pricingService } from "@/services/backendApi";

const Pricing = () => {
  const [packages, setPackages] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchPricing = async () => {
      try {
        const response = await pricingService.getActivePricing();
        if (response.success) {
          const mappedPackages = response.pricing_plans.map((plan: any) => {
            let iconComponent = Zap;
            switch (plan.icon) {
              case 'Star':
                iconComponent = Star;
                break;
              case 'Crown':
                iconComponent = Crown;
                break;
              case 'Rocket':
                iconComponent = Rocket;
                break;
              default:
                iconComponent = Zap;
            }
            
            return {
              id: plan.id,
              name: plan.name,
              subtitle: plan.subtitle || "",
              price: plan.price || "0",
              period: plan.period || "ribu",
              description: plan.description || "",
              icon: iconComponent,
              color: plan.color || "bg-blue-600",
              popular: plan.popular || false,
              features: plan.features || [],
              deliveryTime: plan.delivery_time || "3-5 hari kerja",
              technologies: plan.technologies || []
            };
          });
          
          setPackages(mappedPackages);
        }
      } catch (error) {
        console.error('Failed to fetch pricing plans:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchPricing();
  }, []);

  return (
    <section id="pricing" className="py-20 bg-gray-50">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-purple-600/10 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 border border-purple-200">
            <span className="w-2 h-2 bg-purple-600 rounded-full"></span>
            Paket Layanan
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Harga Terjangkau untuk Mahasiswa & Bisnis
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Website profesional dengan harga mahasiswa! Mulai dari Rp 299K untuk tugas kuliah, portfolio, dan bisnis kecil
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {loading && (
            <div className="col-span-full text-center text-gray-500">Memuat paket harga...</div>
          )}
          {!loading && packages.length === 0 && (
            <div className="col-span-full text-center text-gray-500">Belum ada paket yang tersedia.</div>
          )}
          {!loading && packages.map((pkg, index) => (
            <Card 
              key={index} 
              className={`relative p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-200 shadow-lg overflow-hidden group bg-white ${
                pkg.popular ? 'ring-2 ring-blue-600 shadow-blue-600/20' : ''
              }`}
            >
              {/* Popular badge */}
              {pkg.popular && (
                <div className="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                  <div className="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-semibold flex items-center gap-1 shadow-md">
                    <Star className="w-3 h-3" />
                    Terpopuler
                  </div>
                </div>
              )}

              {/* Package Icon */}
              <div className={`w-16 h-16 ${pkg.color} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-md`}>
                <pkg.icon className="w-8 h-8 text-white" />
              </div>

              {/* Package Info */}
              <div className="mb-6">
                <h3 className="text-2xl font-bold text-gray-800 mb-2">{pkg.name}</h3>
                <p className="text-blue-600 font-semibold mb-3">{pkg.subtitle}</p>
                <div className="mb-4">
                  <span className="text-4xl font-bold text-gray-800">
                    {pkg.price === "Konsultasi" ? "Konsultasi" : `Rp ${pkg.price}`}
                  </span>
                  {pkg.price !== "Konsultasi" && (
                    <span className="text-gray-600 ml-1">{pkg.period}</span>
                  )}
                  {pkg.price === "Konsultasi" && (
                    <span className="text-green-600 ml-1 text-lg font-semibold">{pkg.period}</span>
                  )}
                </div>
                <p className="text-gray-600 text-sm leading-relaxed">
                  {pkg.description}
                </p>
              </div>

              {/* Features List */}
              <div className="mb-8">
                <ul className="space-y-3">
                  {pkg.features.map((feature, idx) => (
                    <li key={idx} className="flex items-start gap-3">
                      <Check className="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0" />
                      <span className="text-gray-600 text-sm">{feature}</span>
                    </li>
                  ))}
                </ul>
              </div>

              {/* Delivery Time */}
              <div className="mb-6 p-3 bg-gray-50 rounded-lg border border-gray-100">
                <div className="text-sm font-semibold text-gray-700 mb-1">Waktu Pengerjaan:</div>
                <div className="text-sm text-gray-600">{pkg.deliveryTime}</div>
              </div>

              {/* Technologies */}
              <div className="mb-6">
                <div className="text-sm font-semibold text-gray-700 mb-2">Teknologi:</div>
                <div className="flex flex-wrap gap-1">
                  {pkg.technologies.map((tech, idx) => (
                    <span key={idx} className="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">
                      {tech}
                    </span>
                  ))}
                </div>
              </div>

              {/* CTA Button */}
              <Button 
                className={`w-full ${pkg.popular ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-800 hover:bg-gray-900'} transition-colors duration-300`}
                size="lg"
              >
                {pkg.price === "Konsultasi" ? "Konsultasi Gratis" : "Pilih Paket"}
              </Button>
            </Card>
          ))}
        </div>

        {/* Additional Info */}
        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          <Card className="p-6 text-center border border-gray-200 shadow-lg bg-white">
            <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
              <Check className="w-6 h-6 text-green-600" />
            </div>
            <h3 className="text-lg font-bold text-gray-800 mb-2">Harga Mahasiswa</h3>
            <p className="text-gray-600 text-sm">Harga terjangkau khusus untuk mahasiswa dan bisnis kecil</p>
          </Card>

          <Card className="p-6 text-center border border-gray-200 shadow-lg bg-white">
            <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
              <Zap className="w-6 h-6 text-blue-600" />
            </div>
            <h3 className="text-lg font-bold text-gray-800 mb-2">Pengerjaan Cepat</h3>
            <p className="text-gray-600 text-sm">3-7 hari selesai untuk tugas kuliah dan project kecil</p>
          </Card>

          <Card className="p-6 text-center border border-gray-200 shadow-lg bg-white">
            <div className="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
              <Crown className="w-6 h-6 text-purple-600" />
            </div>
            <h3 className="text-lg font-bold text-gray-800 mb-2">Support WhatsApp</h3>
            <p className="text-gray-600 text-sm">Dukungan via WhatsApp untuk konsultasi dan bantuan teknis</p>
          </Card>
        </div>

        {/* FAQ Section */}
        <div className="mt-16 bg-white rounded-2xl p-8 border border-gray-200 shadow-lg">
          <h3 className="text-2xl font-bold text-gray-800 mb-8 text-center">Frequently Asked Questions</h3>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h4 className="font-semibold text-gray-800 mb-2">Apakah ada biaya tersembunyi?</h4>
              <p className="text-gray-600 text-sm">Tidak ada biaya tersembunyi. Semua biaya sudah termasuk hosting dan domain gratis.</p>
            </div>
            <div>
              <h4 className="font-semibold text-gray-800 mb-2">Bagaimana sistem pembayaran?</h4>
              <p className="text-gray-600 text-sm">Pembayaran dapat dilakukan bertahap: 50% di awal, 50% setelah project selesai.</p>
            </div>
            <div>
              <h4 className="font-semibold text-gray-800 mb-2">Apakah bisa untuk tugas kuliah?</h4>
              <p className="text-gray-600 text-sm">Tentu! Kami sudah berpengalaman membantu mahasiswa dengan tugas mata kuliah dan project akhir.</p>
            </div>
            <div>
              <h4 className="font-semibold text-gray-800 mb-2">Bagaimana dengan maintenance website?</h4>
              <p className="text-gray-600 text-sm">Kami menyediakan layanan maintenance dengan harga terjangkau untuk mahasiswa dan bisnis kecil.</p>
            </div>
          </div>
        </div>

        {/* CTA */}
        <div className="mt-16 text-center">
          <Card className="p-8 bg-gradient-to-r from-blue-600 to-indigo-600 text-white border-0 max-w-4xl mx-auto shadow-xl">
            <h3 className="text-3xl font-bold mb-4">Masih Bingung Pilih Paket?</h3>
            <p className="text-lg mb-6 opacity-90">
              Konsultasikan kebutuhan project Anda dengan tim expert kami. 
              Dapatkan rekomendasi paket yang paling sesuai dengan budget mahasiswa dan goals bisnis Anda.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button variant="default" size="lg" className="bg-white text-blue-600 hover:bg-gray-100">
                Konsultasi Gratis Sekarang
              </Button>
              <Button variant="outline" size="lg" className="bg-white/10 border-white/20 text-white hover:bg-white/20">
                Lihat Portfolio
              </Button>
            </div>
          </Card>
        </div>
      </div>
    </section>
  );
};

export default Pricing;