import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Check, Star, Zap, Crown, Rocket } from "lucide-react";

const Pricing = () => {
  const packages = [
    {
      name: "Starter",
      subtitle: "Perfect untuk UKM",
      price: "2.5",
      period: "juta",
      description: "Paket dasar untuk website company profile sederhana dan professional",
      icon: Zap,
      color: "bg-blue-500",
      popular: false,
      features: [
        "Desain responsive (mobile-friendly)",
        "5-7 halaman website",
        "Optimasi SEO dasar",
        "Kontak form & Google Maps",
        "Hosting gratis 1 tahun",
        "Domain .com gratis",
        "SSL Certificate",
        "2x revisi desain",
        "Training penggunaan",
        "Support 3 bulan"
      ],
      deliveryTime: "7-10 hari kerja",
      technologies: ["HTML5", "CSS3", "JavaScript", "PHP"]
    },
    {
      name: "Professional",
      subtitle: "Untuk bisnis berkembang",
      price: "4.5",
      period: "juta",
      description: "Solusi lengkap untuk perusahaan yang membutuhkan fitur lebih advanced",
      icon: Star,
      color: "bg-purple-500",
      popular: true,
      features: [
        "Semua fitur Starter Package",
        "8-12 halaman website",
        "CMS untuk update konten",
        "Galeri foto & video",
        "Blog/artikel system",
        "Social media integration",
        "WhatsApp Business API",
        "Live chat widget",
        "Analytics & reporting",
        "Backup otomatis",
        "5x revisi desain",
        "Support 6 bulan"
      ],
      deliveryTime: "10-14 hari kerja",
      technologies: ["Laravel", "MySQL", "Bootstrap", "jQuery"]
    },
    {
      name: "Enterprise",
      subtitle: "Untuk korporasi besar",
      price: "8.5",
      period: "juta",
      description: "Paket premium dengan fitur enterprise dan sistem yang kompleks",
      icon: Crown,
      color: "bg-orange-500",
      popular: false,
      features: [
        "Semua fitur Professional Package",
        "Unlimited halaman",
        "Multi-language support",
        "User management system",
        "Advanced CMS dashboard",
        "E-commerce integration",
        "Payment gateway",
        "API development",
        "Advanced SEO optimization",
        "Performance optimization",
        "Security enhancement",
        "Custom features",
        "Unlimited revisi",
        "Support 12 bulan"
      ],
      deliveryTime: "14-21 hari kerja",
      technologies: ["Laravel", "Vue.js", "MySQL", "Redis"]
    },
    {
      name: "Custom",
      subtitle: "Solusi khusus",
      price: "Konsultasi",
      period: "gratis",
      description: "Paket khusus sesuai kebutuhan spesifik bisnis Anda",
      icon: Rocket,
      color: "bg-gradient-to-r from-pink-500 to-purple-600",
      popular: false,
      features: [
        "Analisis kebutuhan mendalam",
        "Custom design & development",
        "Integrasi sistem existing",
        "Microservices architecture",
        "Cloud deployment",
        "DevOps implementation",
        "Mobile app development",
        "AI/ML integration",
        "Blockchain integration",
        "IoT connectivity",
        "Advanced analytics",
        "24/7 monitoring",
        "Dedicated team",
        "Lifetime support"
      ],
      deliveryTime: "Sesuai scope project",
      technologies: ["Custom Stack", "Cloud Native", "AI/ML", "Blockchain"]
    }
  ];

  return (
    <section id="pricing" className="py-20 bg-white">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
            <span className="w-2 h-2 bg-primary rounded-full"></span>
            Paket Layanan
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Pilih Paket yang Tepat
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Kami menyediakan berbagai paket layanan yang fleksibel untuk memenuhi kebutuhan bisnis Anda, 
            dari startup hingga enterprise
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {packages.map((pkg, index) => (
            <Card 
              key={index} 
              className={`relative p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-0 shadow-lg overflow-hidden group ${
                pkg.popular ? 'ring-2 ring-primary shadow-primary/20' : ''
              }`}
            >
              {/* Popular badge */}
              {pkg.popular && (
                <div className="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                  <div className="bg-primary text-white px-4 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                    <Star className="w-3 h-3" />
                    Terpopuler
                  </div>
                </div>
              )}

              {/* Package Icon */}
              <div className={`w-16 h-16 ${pkg.color} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300`}>
                <pkg.icon className="w-8 h-8 text-white" />
              </div>

              {/* Package Info */}
              <div className="mb-6">
                <h3 className="text-2xl font-bold text-gray-900 mb-2">{pkg.name}</h3>
                <p className="text-primary font-semibold mb-3">{pkg.subtitle}</p>
                <div className="mb-4">
                  <span className="text-4xl font-bold text-gray-900">
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
                      <Check className="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" />
                      <span className="text-gray-600 text-sm">{feature}</span>
                    </li>
                  ))}
                </ul>
              </div>

              {/* Delivery Time */}
              <div className="mb-6 p-3 bg-gray-50 rounded-lg">
                <div className="text-sm font-semibold text-gray-700 mb-1">Waktu Pengerjaan:</div>
                <div className="text-sm text-gray-600">{pkg.deliveryTime}</div>
              </div>

              {/* Technologies */}
              <div className="mb-6">
                <div className="text-sm font-semibold text-gray-700 mb-2">Teknologi:</div>
                <div className="flex flex-wrap gap-1">
                  {pkg.technologies.map((tech, idx) => (
                    <span key={idx} className="px-2 py-1 bg-primary/10 text-primary rounded text-xs font-medium">
                      {tech}
                    </span>
                  ))}
                </div>
              </div>

              {/* CTA Button */}
              <Button 
                className={`w-full ${pkg.popular ? 'bg-primary hover:bg-primary/90' : 'bg-gray-900 hover:bg-gray-800'} transition-colors duration-300`}
                size="lg"
              >
                {pkg.price === "Konsultasi" ? "Konsultasi Gratis" : "Pilih Paket"}
              </Button>
            </Card>
          ))}
        </div>

        {/* Additional Info */}
        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          <Card className="p-6 text-center border-0 shadow-lg">
            <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
              <Check className="w-6 h-6 text-green-600" />
            </div>
            <h3 className="text-lg font-bold text-gray-900 mb-2">Garansi Kepuasan</h3>
            <p className="text-gray-600 text-sm">100% garansi uang kembali jika tidak puas dengan hasil</p>
          </Card>

          <Card className="p-6 text-center border-0 shadow-lg">
            <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
              <Zap className="w-6 h-6 text-blue-600" />
            </div>
            <h3 className="text-lg font-bold text-gray-900 mb-2">Pengerjaan Cepat</h3>
            <p className="text-gray-600 text-sm">Tim professional yang mengerjakan proyek dengan efisien</p>
          </Card>

          <Card className="p-6 text-center border-0 shadow-lg">
            <div className="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
              <Crown className="w-6 h-6 text-purple-600" />
            </div>
            <h3 className="text-lg font-bold text-gray-900 mb-2">Support Premium</h3>
            <p className="text-gray-600 text-sm">Dukungan teknis berkelanjutan setelah project selesai</p>
          </Card>
        </div>

        {/* FAQ Section */}
        <div className="mt-16 bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8">
          <h3 className="text-2xl font-bold text-gray-900 mb-8 text-center">Frequently Asked Questions</h3>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h4 className="font-semibold text-gray-900 mb-2">Apakah ada biaya tersembunyi?</h4>
              <p className="text-gray-600 text-sm">Tidak ada biaya tersembunyi. Semua biaya sudah termasuk dalam paket yang dipilih.</p>
            </div>
            <div>
              <h4 className="font-semibold text-gray-900 mb-2">Bagaimana sistem pembayaran?</h4>
              <p className="text-gray-600 text-sm">Pembayaran dapat dilakukan bertahap: 50% di awal, 50% setelah project selesai.</p>
            </div>
            <div>
              <h4 className="font-semibold text-gray-900 mb-2">Apakah bisa request fitur tambahan?</h4>
              <p className="text-gray-600 text-sm">Tentu! Kami sangat fleksibel untuk menambahkan fitur sesuai kebutuhan bisnis Anda.</p>
            </div>
            <div>
              <h4 className="font-semibold text-gray-900 mb-2">Bagaimana dengan maintenance website?</h4>
              <p className="text-gray-600 text-sm">Kami menyediakan layanan maintenance bulanan dengan harga terjangkau setelah project selesai.</p>
            </div>
          </div>
        </div>

        {/* CTA */}
        <div className="mt-16 text-center">
          <Card className="p-8 bg-gradient-to-r from-primary to-purple-600 text-white border-0 max-w-4xl mx-auto">
            <h3 className="text-3xl font-bold mb-4">Masih Bingung Pilih Paket?</h3>
            <p className="text-lg mb-6 opacity-90">
              Konsultasikan kebutuhan project Anda dengan tim expert kami. 
              Dapatkan rekomendasi paket yang paling sesuai dengan budget dan goals bisnis Anda.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button variant="hero" size="lg">
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