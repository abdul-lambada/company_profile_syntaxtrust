import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Menu, X, Code2 } from "lucide-react";
import { useActiveSection } from "@/hooks/use-active-section";

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);

  const navItems = [
    { name: "Beranda", href: "#home", id: "home" },
    { name: "Layanan", href: "#services", id: "services" },
    { name: "Klien", href: "#clients", id: "clients" },
    { name: "Teknologi", href: "#tech", id: "tech" },
    { name: "Portfolio", href: "#portfolio", id: "portfolio" },
    { name: "Tim", href: "#team", id: "team" },
    { name: "Paket", href: "#pricing", id: "pricing" },
    { name: "Kontak", href: "#contact", id: "contact" },
  ];

  const sectionIds = navItems.map(item => item.id);
  const activeSection = useActiveSection(sectionIds);

  const scrollToSection = (href: string) => {
    const element = document.querySelector(href);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
    setIsOpen(false);
  };

  return (
    <nav className="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/50 shadow-sm">
      <div className="container mx-auto px-6">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <div className="flex items-center space-x-2">
            <div className="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
              <Code2 className="w-6 h-6 text-white" />
            </div>
            <span className="text-xl font-bold text-gray-800">SyntaxTrust</span>
          </div>

          {/* Desktop Menu */}
          <div className="hidden md:flex items-center space-x-8">
            {navItems.map((item) => (
              <button
                key={item.name}
                onClick={() => scrollToSection(item.href)}
                className={`text-transition font-medium relative hover:scale-105 ${
                  activeSection === item.id
                    ? "text-purple-600"
                    : "text-gray-700 hover:text-purple-600"
                }`}
              >
                {item.name}
                {activeSection === item.id && (
                  <div className="nav-indicator"></div>
                )}
              </button>
            ))}
            <Button variant="default" size="sm" className="bg-purple-600 hover:bg-purple-700 text-white">
              Konsultasi Gratis
            </Button>
          </div>

          {/* Mobile Menu Button */}
          <div className="md:hidden">
            <Button
              variant="ghost"
              size="icon"
              onClick={() => setIsOpen(!isOpen)}
              className="text-gray-700 hover:text-purple-600"
            >
              {isOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </Button>
          </div>
        </div>

        {/* Mobile Menu */}
        {isOpen && (
          <div className="md:hidden py-4 border-t border-gray-200 bg-white/95 backdrop-blur-md">
            <div className="flex flex-col space-y-4">
              {navItems.map((item) => (
                <button
                  key={item.name}
                  onClick={() => scrollToSection(item.href)}
                  className={`text-transition font-medium px-4 py-2 text-left rounded-lg ${
                    activeSection === item.id
                      ? "text-purple-600 bg-purple-50 border border-purple-200"
                      : "text-gray-700 hover:text-purple-600 hover:bg-gray-50"
                  }`}
                >
                  {item.name}
                </button>
              ))}
              <div className="px-4">
                <Button variant="default" size="sm" className="w-full bg-purple-600 hover:bg-purple-700 text-white">
                  Konsultasi Gratis
                </Button>
              </div>
            </div>
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;