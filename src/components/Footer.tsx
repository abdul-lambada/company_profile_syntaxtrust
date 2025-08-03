import { useState, useEffect } from "react";
import { Code2, Mail, Phone, MapPin, Facebook, Twitter, Instagram, Linkedin } from "lucide-react";
import { settingsService } from "@/services/backendApi";

const Footer = () => {
  const [siteName, setSiteName] = useState("SyntaxTrust");
  const [loading, setLoading] = useState(true);
  
  useEffect(() => {
    const fetchSettings = async () => {
      try {
        const response = await settingsService.getSettings();
        if (response.success) {
          // Extract site name from settings
          const name = response.settings.find((s: any) => s.setting_key === 'site_name')?.setting_value || "SyntaxTrust";
          setSiteName(name);
        }
      } catch (error) {
        console.error('Failed to fetch site name:', error);
        // Keep using the hardcoded data if API fails
      } finally {
        setLoading(false);
      }
    };
    
    fetchSettings();
  }, []);
  
  return (
    <footer className="bg-gray-800 text-white">
      <div className="container mx-auto px-6 py-16">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          {/* Company Info */}
          <div className="col-span-1 md:col-span-2">
            <div className="flex items-center space-x-2 mb-6">
              <div className="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                <Code2 className="w-6 h-6 text-white" />
              </div>
              <span className="text-2xl font-bold">{siteName}</span>
            </div>
            <p className="text-gray-300 mb-6 max-w-md leading-relaxed">
              Mitra terpercaya untuk mahasiswa dan bisnis kecil. Kami menghadirkan website profesional dengan harga terjangkau untuk tugas kuliah, portfolio, dan bisnis Anda.
            </p>
            <div className="flex space-x-4">
              <a href="#" className="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
                <Facebook className="w-5 h-5" />
              </a>
              <a href="#" className="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
                <Twitter className="w-5 h-5" />
              </a>
              <a href="#" className="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
                <Instagram className="w-5 h-5" />
              </a>
              <a href="#" className="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
                <Linkedin className="w-5 h-5" />
              </a>
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h3 className="text-lg font-semibold mb-6">Layanan</h3>
            <ul className="space-y-3">
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">Website Portfolio</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">Website Tugas Kuliah</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">Website Bisnis Kecil</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">Website UMKM</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">Perbaikan & Maintenance</a></li>
            </ul>
          </div>

          {/* Contact Info */}
          <div>
            <h3 className="text-lg font-semibold mb-6">Kontak</h3>
            <ul className="space-y-3">
              <li className="flex items-center gap-3">
                <MapPin className="w-4 h-4 text-blue-400" />
                <span className="text-gray-300 text-sm">Jl. Cibiru No.01, 
                  Sangkanhurip, <br />
                  Kec. Sindang, <br />
                  Kabupaten Majalengka, <br />
                  Jawa Barat 45471</span>
              </li>
              <li className="flex items-center gap-3">
                <Phone className="w-4 h-4 text-green-400" />
                <span className="text-gray-300 text-sm">+6285156553226</span>
              </li>
              <li className="flex items-center gap-3">
                <Mail className="w-4 h-4 text-purple-400" />
                <span className="text-gray-300 text-sm">engineertekno@gmail.com</span>
              </li>
            </ul>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="border-t border-gray-700 mt-12 pt-8">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <p className="text-gray-300 text-sm">
              © 2025 SyntaxTrust. All rights reserved.
            </p>
            <div className="flex space-x-6 mt-4 md:mt-0">
              <a href="#" className="text-gray-300 hover:text-white text-sm transition-colors">Privacy Policy</a>
              <a href="#" className="text-gray-300 hover:text-white text-sm transition-colors">Terms of Service</a>
              <a href="#" className="text-gray-300 hover:text-white text-sm transition-colors">Cookie Policy</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;