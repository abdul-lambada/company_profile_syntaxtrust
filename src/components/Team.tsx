import { useState, useEffect } from "react";
import { Card } from "@/components/ui/card";
import { Linkedin, Github, Mail } from "lucide-react";
import LazyImage from "./LazyImage";
import { teamService } from "@/services/backendApi";

const Team = () => {
  const [teamMembers, setTeamMembers] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchTeam = async () => {
      try {
        const response = await teamService.getActiveTeam();
        if (response.success) {
          // Map the API data to the component structure
          const mappedTeam = response.team.map((member: any) => ({
            id: member.id,
            name: member.name,
            position: member.position,
            description: member.description,
            image: member.image || `https://images.unsplash.com/photo-${member.id}?w=300&h=300&fit=crop&crop=face`,
            specialties: member.skills || [],
            social: {
              linkedin: member.linkedin || "#",
              github: member.github || "#",
              email: member.email || `member${member.id}@syntaxtrust.com`
            }
          }));

          setTeamMembers(mappedTeam);
        }
      } catch (error) {
        console.error('Failed to fetch team members:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchTeam();
  }, []);

  return (
    <section id="team" className="py-20 bg-white">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-purple-600/10 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 border border-purple-200">
            <span className="w-2 h-2 bg-purple-600 rounded-full"></span>
            Tim Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Tim Mahasiswa yang Berpengalaman
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Tim mahasiswa dan fresh graduate yang sudah berpengalaman membantu ratusan mahasiswa dengan tugas kuliah dan bisnis kecil
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {loading && (
            <div className="col-span-full text-center text-gray-500">Memuat data tim...</div>
          )}
          {!loading && teamMembers.map((member, index) => (
            <Card 
              key={index} 
              className="group p-8 text-center hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-200 shadow-lg bg-white overflow-hidden relative"
            >
              {/* Background decoration */}
              <div className="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
              
              {/* Profile Image */}
              <div className="relative mb-6">
                <div className="w-24 h-24 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                  <LazyImage 
                    src={member.image} 
                    alt={member.name}
                    className="w-full h-full"
                  />
                </div>
                {/* Online indicator */}
                <div className="absolute bottom-2 right-1/2 transform translate-x-8 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
              </div>

              {/* Member Info */}
              <div className="mb-6">
                <h3 className="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors duration-300">
                  {member.name}
                </h3>
                <p className="text-purple-600 font-semibold mb-3">
                  {member.position}
                </p>
                <p className="text-gray-600 text-sm leading-relaxed">
                  {member.description}
                </p>
              </div>

              {/* Specialties */}
              <div className="mb-6">
                <div className="flex flex-wrap gap-2 justify-center">
                  {member.specialties.map((specialty, idx) => (
                    <span 
                      key={idx}
                      className="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium hover:bg-purple-600 hover:text-white transition-colors duration-200"
                    >
                      {specialty}
                    </span>
                  ))}
                </div>
              </div>

              {/* Social Links */}
              <div className="flex justify-center space-x-4">
                <a 
                  href={member.social.linkedin}
                  className="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 group/social"
                >
                  <Linkedin className="w-4 h-4" />
                </a>
                <a 
                  href={member.social.github}
                  className="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-800 hover:text-white transition-all duration-300 group/social"
                >
                  <Github className="w-4 h-4" />
                </a>
                <a 
                  href={`mailto:${member.social.email}`}
                  className="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition-all duration-300 group/social"
                >
                  <Mail className="w-4 h-4" />
                </a>
              </div>
            </Card>
          ))}
        </div>

        {/* Team Stats */}
        <div className="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8">
          <div className="text-center">
            <div className="text-4xl font-bold text-purple-600 mb-2">6+</div>
            <div className="text-gray-600">Mahasiswa Expert</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-purple-600 mb-2">200+</div>
            <div className="text-gray-600">Mahasiswa Dibantu</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-purple-600 mb-2">80+</div>
            <div className="text-gray-600">Bisnis Kecil</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-purple-600 mb-2">24/7</div>
            <div className="text-gray-600">WhatsApp Support</div>
          </div>
        </div>

        {/* Join Team CTA */}
        <div className="mt-16 text-center">
          <Card className="p-8 bg-gradient-to-r from-blue-600 to-indigo-600 text-white border-0 shadow-xl">
            <h3 className="text-2xl md:text-3xl font-bold mb-4">
              Bergabung dengan Tim Mahasiswa Kami
            </h3>
            <p className="text-lg mb-6 opacity-90 max-w-2xl mx-auto">
              Kami selalu mencari mahasiswa berbakat untuk bergabung dengan tim kami. 
              Dapatkan pengalaman kerja sambil membantu mahasiswa lain dengan project mereka.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <a 
                href="mailto:careers@syntaxtrust.com"
                className="inline-flex items-center justify-center px-6 py-3 bg-white/20 text-white rounded-lg hover:bg-white/30 transition-colors duration-300 font-semibold"
              >
                Kirim CV Mahasiswa
              </a>
              <a 
                href="#contact"
                className="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition-colors duration-300 font-semibold"
              >
                Hubungi via WhatsApp
              </a>
            </div>
          </Card>
        </div>
      </div>
    </section>
  );
};

export default Team;