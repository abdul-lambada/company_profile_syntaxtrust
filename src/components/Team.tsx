import { Card } from "@/components/ui/card";
import { Linkedin, Github, Mail } from "lucide-react";

const Team = () => {
  const teamMembers = [
    {
      name: "Ahmad Rizki",
      position: "Full Stack Developer",
      description: "Expert dalam PHP, Laravel, dan JavaScript dengan pengalaman 5+ tahun dalam pengembangan web.",
      image: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face",
      specialties: ["PHP", "Laravel", "Vue.js", "MySQL"],
      social: {
        linkedin: "#",
        github: "#",
        email: "ahmad@syntaxtrust.com"
      }
    },
    {
      name: "Sari Indah",
      position: "Frontend Developer",
      description: "Spesialis UI/UX dengan keahlian dalam React, Angular, dan modern CSS frameworks.",
      image: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=300&fit=crop&crop=face",
      specialties: ["React", "Angular", "CSS3", "Figma"],
      social: {
        linkedin: "#",
        github: "#",
        email: "sari@syntaxtrust.com"
      }
    },
    {
      name: "Budi Santoso",
      position: "Backend Developer",
      description: "Architect sistem backend yang robust dengan expertise dalam microservices dan database optimization.",
      image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face",
      specialties: ["Node.js", "Python", "MongoDB", "Docker"],
      social: {
        linkedin: "#",
        github: "#",
        email: "budi@syntaxtrust.com"
      }
    },
    {
      name: "Lisa Permata",
      position: "UI/UX Designer",
      description: "Creative designer yang berfokus pada user experience dan interface design yang intuitive.",
      image: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop&crop=face",
      specialties: ["Figma", "Adobe XD", "Photoshop", "Illustrator"],
      social: {
        linkedin: "#",
        github: "#",
        email: "lisa@syntaxtrust.com"
      }
    },
    {
      name: "Andi Pratama",
      position: "DevOps Engineer",
      description: "Specialist dalam deployment, CI/CD, dan infrastructure management untuk aplikasi scalable.",
      image: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop&crop=face",
      specialties: ["AWS", "Docker", "Kubernetes", "Jenkins"],
      social: {
        linkedin: "#",
        github: "#",
        email: "andi@syntaxtrust.com"
      }
    },
    {
      name: "Maya Sari",
      position: "Project Manager",
      description: "Experienced project manager yang memastikan delivery proyek tepat waktu dan sesuai quality standard.",
      image: "https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=300&h=300&fit=crop&crop=face",
      specialties: ["Agile", "Scrum", "Jira", "Team Management"],
      social: {
        linkedin: "#",
        github: "#",
        email: "maya@syntaxtrust.com"
      }
    }
  ];

  return (
    <section id="team" className="py-20 bg-gradient-to-br from-gray-50 to-white">
      <div className="container mx-auto px-6">
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
            <span className="w-2 h-2 bg-primary rounded-full"></span>
            Tim Kami
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Bertemu dengan Tim Expert
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Tim professional berpengalaman yang siap mewujudkan visi digital Anda dengan keahlian terdepan di bidangnya
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {teamMembers.map((member, index) => (
            <Card 
              key={index} 
              className="group p-8 text-center hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-0 shadow-lg bg-white overflow-hidden relative"
            >
              {/* Background decoration */}
              <div className="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary to-purple-600"></div>
              
              {/* Profile Image */}
              <div className="relative mb-6">
                <div className="w-24 h-24 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                  <img 
                    src={member.image} 
                    alt={member.name}
                    className="w-full h-full object-cover"
                  />
                </div>
                {/* Online indicator */}
                <div className="absolute bottom-2 right-1/2 transform translate-x-8 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
              </div>

              {/* Member Info */}
              <div className="mb-6">
                <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors duration-300">
                  {member.name}
                </h3>
                <p className="text-primary font-semibold mb-3">
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
                      className="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium hover:bg-primary hover:text-white transition-colors duration-200"
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
            <div className="text-4xl font-bold text-primary mb-2">6+</div>
            <div className="text-gray-600">Expert Developers</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-primary mb-2">15+</div>
            <div className="text-gray-600">Combined Years</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-primary mb-2">100+</div>
            <div className="text-gray-600">Projects Delivered</div>
          </div>
          <div className="text-center">
            <div className="text-4xl font-bold text-primary mb-2">24/7</div>
            <div className="text-gray-600">Team Support</div>
          </div>
        </div>

        {/* Join Team CTA */}
        <div className="mt-16 text-center">
          <Card className="p-8 bg-gradient-to-r from-primary to-purple-600 text-white border-0">
            <h3 className="text-2xl md:text-3xl font-bold mb-4">
              Bergabung dengan Tim Kami
            </h3>
            <p className="text-lg mb-6 opacity-90 max-w-2xl mx-auto">
              Kami selalu mencari talent terbaik untuk bergabung dengan tim professional kami. 
              Mari berkembang bersama dalam lingkungan kerja yang supportive dan innovative.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <a 
                href="mailto:careers@syntaxtrust.com"
                className="inline-flex items-center justify-center px-6 py-3 bg-white/20 text-white rounded-lg hover:bg-white/30 transition-colors duration-300 font-semibold"
              >
                Kirim CV Anda
              </a>
              <a 
                href="#contact"
                className="inline-flex items-center justify-center px-6 py-3 bg-white text-primary rounded-lg hover:bg-gray-100 transition-colors duration-300 font-semibold"
              >
                Hubungi HR
              </a>
            </div>
          </Card>
        </div>
      </div>
    </section>
  );
};

export default Team;