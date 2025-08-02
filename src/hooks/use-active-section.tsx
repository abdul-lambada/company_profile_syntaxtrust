import { useState, useEffect } from 'react';

export function useActiveSection(sectionIds: string[]) {
  const [activeSection, setActiveSection] = useState<string>('home');

  useEffect(() => {
    const observers: IntersectionObserver[] = [];
    const sectionElements: HTMLElement[] = [];

    // Create intersection observer for each section
    sectionIds.forEach((sectionId) => {
      const element = document.getElementById(sectionId);
      if (element) {
        sectionElements.push(element);
        
        const observer = new IntersectionObserver(
          (entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting) {
                // Add a small delay to ensure smooth transitions
                setTimeout(() => {
                  setActiveSection(sectionId);
                }, 100);
              }
            });
          },
          {
            rootMargin: '-20% 0px -20% 0px', // Adjust this value to control when a section is considered "active"
            threshold: 0.1,
          }
        );

        observer.observe(element);
        observers.push(observer);
      }
    });

    // Set initial active section based on scroll position
    const handleInitialScroll = () => {
      const scrollPosition = window.scrollY + 100; // Offset for navbar
      
      for (let i = sectionIds.length - 1; i >= 0; i--) {
        const element = document.getElementById(sectionIds[i]);
        if (element && element.offsetTop <= scrollPosition) {
          setActiveSection(sectionIds[i]);
          break;
        }
      }
    };

    // Call once on mount
    handleInitialScroll();

    // Cleanup function
    return () => {
      observers.forEach((observer) => observer.disconnect());
    };
  }, [sectionIds]);

  return activeSection;
} 