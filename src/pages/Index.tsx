import Navbar from "@/components/Navbar";
import Hero from "@/components/Hero";
import Services from "@/components/Services";
import ClientCarousel from "@/components/ClientCarousel";
import TechStack from "@/components/TechStack";
import Team from "@/components/Team";
import Portfolio from "@/components/Portfolio";
import Pricing from "@/components/Pricing";
import Contact from "@/components/Contact";
import Footer from "@/components/Footer";

const Index = () => {
  return (
    <div className="min-h-screen">
      <Navbar />
      <main>
        <section id="home">
          <Hero />
        </section>
        <section id="services">
          <Services />
        </section>
        <section id="clients">
          <ClientCarousel />
        </section>
        <section id="tech">
          <TechStack />
        </section>
        <section id="portfolio">
          <Portfolio />
        </section>
        <section id="team">
          <Team />
        </section>
        <section id="pricing">
          <Pricing />
        </section>
        <section id="contact">
          <Contact />
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default Index;
