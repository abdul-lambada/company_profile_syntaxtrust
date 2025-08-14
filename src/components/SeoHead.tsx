import { useEffect } from 'react';
import { useSettings } from '@/hooks/useSettings';

function ensureMeta(name: string, content: string) {
  let el = document.querySelector(`meta[name="${name}"]`) as HTMLMetaElement | null;
  if (!el) {
    el = document.createElement('meta');
    el.setAttribute('name', name);
    document.head.appendChild(el);
  }
  el.setAttribute('content', content);
}

function ensureOg(property: string, content: string) {
  let el = document.querySelector(`meta[property="${property}"]`) as HTMLMetaElement | null;
  if (!el) {
    el = document.createElement('meta');
    el.setAttribute('property', property);
    document.head.appendChild(el);
  }
  el.setAttribute('content', content);
}

export default function SeoHead() {
  const { settings } = useSettings();
  const siteName = (settings.site_name as string) || 'SyntaxTrust';
  const siteUrl = (settings.site_url as string) || 'https://syntaxtrust.com';
  const description = (settings.site_description as string) || 'Website profesional dengan harga terjangkau.';
  const logoUrl = (settings.site_logo_url as string) || '/og-image.png';

  useEffect(() => {
    // Basic meta
    ensureMeta('description', description);
    ensureOg('og:title', `${siteName} - Website Profesional Terjangkau`);
    ensureOg('og:site_name', siteName);
    ensureOg('og:url', siteUrl);
    ensureOg('og:description', description);
    ensureOg('og:image', logoUrl);

    // JSON-LD Organization
    const org = {
      '@context': 'https://schema.org',
      '@type': 'Organization',
      name: siteName,
      url: siteUrl,
      logo: logoUrl,
      sameAs: [
        settings.social_facebook,
        settings.social_twitter,
        settings.social_instagram,
        settings.social_linkedin,
      ].filter(Boolean),
      contactPoint: settings.company_phone
        ? [{ '@type': 'ContactPoint', telephone: settings.company_phone, contactType: 'customer support', areaServed: 'ID' }]
        : undefined,
      address: settings.company_address
        ? { '@type': 'PostalAddress', streetAddress: settings.company_address }
        : undefined,
    } as any;

    const scriptId = 'jsonld-organization';
    let script = document.getElementById(scriptId) as HTMLScriptElement | null;
    if (!script) {
      script = document.createElement('script');
      script.type = 'application/ld+json';
      script.id = scriptId;
      document.head.appendChild(script);
    }
    script.text = JSON.stringify(org);
  }, [siteName, siteUrl, description, logoUrl, settings]);

  return null;
}
