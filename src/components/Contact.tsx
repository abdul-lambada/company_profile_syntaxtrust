import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { MapPin, Phone, Mail, Clock, Loader2, CheckCircle, AlertCircle } from "lucide-react";
import ProgressBar from "./ProgressBar";

const Contact = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    service: "Pembuatan Website Baru",
    message: ""
  });
  
  const [errors, setErrors] = useState<Record<string, string>>({});
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitStatus, setSubmitStatus] = useState<'idle' | 'success' | 'error'>('idle');
  const [submitProgress, setSubmitProgress] = useState(0);

  const validateForm = () => {
    const newErrors: Record<string, string> = {};

    // Name validation
    if (!formData.name.trim()) {
      newErrors.name = "Nama lengkap wajib diisi";
    } else if (formData.name.trim().length < 2) {
      newErrors.name = "Nama minimal 2 karakter";
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!formData.email.trim()) {
      newErrors.email = "Email wajib diisi";
    } else if (!emailRegex.test(formData.email)) {
      newErrors.email = "Format email tidak valid";
    }

    // Phone validation
    const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{6,9}$/;
    if (!formData.phone.trim()) {
      newErrors.phone = "Nomor telepon wajib diisi";
    } else if (!phoneRegex.test(formData.phone.replace(/\s/g, ''))) {
      newErrors.phone = "Format nomor telepon tidak valid";
    }

    // Message validation
    if (!formData.message.trim()) {
      newErrors.message = "Deskripsi proyek wajib diisi";
    } else if (formData.message.trim().length < 10) {
      newErrors.message = "Deskripsi minimal 10 karakter";
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleInputChange = (field: string, value: string) => {
    setFormData(prev => ({ ...prev, [field]: value }));
    // Clear error when user starts typing
    if (errors[field]) {
      setErrors(prev => ({ ...prev, [field]: "" }));
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!validateForm()) {
      return;
    }

    setIsSubmitting(true);
    setSubmitStatus('idle');
    setSubmitProgress(0);

    try {
      // Simulate progress
      const progressInterval = setInterval(() => {
        setSubmitProgress(prev => {
          if (prev >= 90) {
            clearInterval(progressInterval);
            return 90;
          }
          return prev + 10;
        });
      }, 200);

      // Simulate API call
      await new Promise(resolve => setTimeout(resolve, 2000));
      
      setSubmitProgress(100);
      
      // Success
      setSubmitStatus('success');
      setFormData({
        name: "",
        email: "",
        phone: "",
        service: "Pembuatan Website Baru",
        message: ""
      });
      
      // Reset success message after 5 seconds
      setTimeout(() => {
        setSubmitStatus('idle');
        setSubmitProgress(0);
      }, 5000);
      
    } catch (error) {
      setSubmitStatus('error');
      setSubmitProgress(0);
      // Reset error message after 5 seconds
      setTimeout(() => setSubmitStatus('idle'), 5000);
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <section id="contact" className="py-20 bg-white">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-purple-600/10 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 border border-purple-200">
            <span className="w-2 h-2 bg-purple-600 rounded-full"></span>
            Hubungi Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Mulai Project Mahasiswa & Bisnis Anda
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Siap mewujudkan website untuk tugas kuliah atau bisnis kecil? Konsultasikan dengan tim mahasiswa expert kami
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Contact Form */}
          <Card className="p-8 shadow-xl border border-gray-200 bg-white">
            <h3 className="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>
            
            {/* Status Messages */}
            {submitStatus === 'success' && (
              <div className="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <CheckCircle className="w-5 h-5 text-green-600" />
                <p className="text-green-800">Pesan berhasil dikirim! Kami akan menghubungi Anda segera.</p>
              </div>
            )}
            
            {submitStatus === 'error' && (
              <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
                <AlertCircle className="w-5 h-5 text-red-600" />
                <p className="text-red-800">Terjadi kesalahan. Silakan coba lagi atau hubungi kami langsung.</p>
              </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap *
                  </label>
                  <Input 
                    placeholder="John Doe" 
                    className={`border-gray-300 focus:border-purple-600 focus:ring-purple-600 ${
                      errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''
                    }`}
                    value={formData.name}
                    onChange={(e) => handleInputChange('name', e.target.value)}
                  />
                  {errors.name && (
                    <p className="text-red-500 text-sm mt-1">{errors.name}</p>
                  )}
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Email *
                  </label>
                  <Input 
                    type="email" 
                    placeholder="john@example.com" 
                    className={`border-gray-300 focus:border-purple-600 focus:ring-purple-600 ${
                      errors.email ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''
                    }`}
                    value={formData.email}
                    onChange={(e) => handleInputChange('email', e.target.value)}
                  />
                  {errors.email && (
                    <p className="text-red-500 text-sm mt-1">{errors.email}</p>
                  )}
                </div>
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Nomor Telepon *
                </label>
                <Input 
                  placeholder="+62 812 3456 7890" 
                  className={`border-gray-300 focus:border-purple-600 focus:ring-purple-600 ${
                    errors.phone ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''
                  }`}
                  value={formData.phone}
                  onChange={(e) => handleInputChange('phone', e.target.value)}
                />
                {errors.phone && (
                  <p className="text-red-500 text-sm mt-1">{errors.phone}</p>
                )}
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Jenis Layanan
                </label>
                <select 
                  className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                  value={formData.service}
                  onChange={(e) => handleInputChange('service', e.target.value)}
                >
                  <option>Website Portfolio Mahasiswa</option>
                  <option>Website Tugas Kuliah</option>
                  <option>Website Bisnis Kecil</option>
                  <option>Website UMKM</option>
                  <option>Perbaikan & Maintenance</option>
                  <option>Konsultasi</option>
                </select>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Deskripsi Proyek *
                </label>
                <Textarea 
                  placeholder="Ceritakan detail proyek Anda..."
                  className={`min-h-[120px] border-gray-300 focus:border-purple-600 focus:ring-purple-600 ${
                    errors.message ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''
                  }`}
                  value={formData.message}
                  onChange={(e) => handleInputChange('message', e.target.value)}
                />
                {errors.message && (
                  <p className="text-red-500 text-sm mt-1">{errors.message}</p>
                )}
              </div>

              {isSubmitting && (
                <div className="mb-4">
                  <ProgressBar 
                    progress={submitProgress} 
                    showLabel 
                    variant={submitProgress === 100 ? "success" : "default"}
                  />
                </div>
              )}
              
              <Button 
                type="submit"
                size="lg" 
                className="w-full bg-purple-600 hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed"
                disabled={isSubmitting}
              >
                {isSubmitting ? (
                  <>
                    <Loader2 className="w-5 h-5 mr-2 animate-spin" />
                    Mengirim Pesan...
                  </>
                ) : (
                  "Kirim Pesan"
                )}
              </Button>
            </form>
          </Card>

          {/* Contact Info */}
          <div className="space-y-8">
            <div>
              <h3 className="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h3>
              <div className="space-y-6">
                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <MapPin className="w-6 h-6 text-blue-600" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-800 mb-1">Alamat</h4>
                    <p className="text-gray-600">
                    Jl. Cibiru No.01, Sangkanhurip, <br />
                  Kec. Sindang, Kabupaten Majalengka, <br />
                  Jawa Barat 45471
                    </p>
                  </div>
                </div>

                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <Phone className="w-6 h-6 text-green-600" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-800 mb-1">Telepon</h4>
                    <p className="text-gray-600">+6285156553226</p>
                    {/* <p className="text-gray-600">+62 812 3456 7890</p> */}
                  </div>
                </div>

                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <Mail className="w-6 h-6 text-purple-600" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-800 mb-1">Email</h4>
                    <p className="text-gray-600">engineertekno@gmail.com</p>
                    {/* <p className="text-gray-600">support@syntaxtrust.com</p> */}
                  </div>
                </div>

                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <Clock className="w-6 h-6 text-orange-600" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-800 mb-1">Jam Operasional</h4>
                    <p className="text-gray-600">Senin - Jumat: 09:00 - 18:00</p>
                    <p className="text-gray-600">Sabtu: 09:00 - 15:00</p>
                    <p className="text-gray-600">Minggu: Tutup</p>
                  </div>
                </div>
              </div>
            </div>

            {/* Quick Stats */}
            <Card className="p-6 bg-gradient-to-br from-purple-600 to-indigo-600 text-white border-0 shadow-xl">
              <h4 className="text-xl font-bold mb-4">Kenapa Memilih Kami?</h4>
              <div className="grid grid-cols-2 gap-4">
                <div className="text-center">
                  <div className="text-2xl font-bold">200+</div>
                  <div className="text-sm opacity-90">Mahasiswa Puas</div>
                </div>
                <div className="text-center">
                  <div className="text-2xl font-bold">80+</div>
                  <div className="text-sm opacity-90">Bisnis Kecil</div>
                </div>
                <div className="text-center">
                  <div className="text-2xl font-bold">Mulai</div>
                  <div className="text-sm opacity-90">Rp 299K</div>
                </div>
                <div className="text-center">
                  <div className="text-2xl font-bold">3-7</div>
                  <div className="text-sm opacity-90">Hari Selesai</div>
                </div>
              </div>
            </Card>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Contact;