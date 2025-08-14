import { useQuery } from '@tanstack/react-query';
import { settingsService } from '@/services/backendApi';

export type SettingsMap = Record<string, any>;

export const SETTINGS_QUERY_KEY = ['settings', 'map'];

export function useSettings() {
  const { data, isLoading, isError, error, refetch } = useQuery({
    queryKey: SETTINGS_QUERY_KEY,
    queryFn: async () => {
      const res = await settingsService.getAllSettingsMap();
      if (res.success) {
        const raw = (res.settingsMap || {}) as SettingsMap;
        // Normalize keys from SQL to canonical keys used by components
        const normalized: SettingsMap = { ...raw };
        // Company/contact info
        if (!normalized.company_address && raw.address) normalized.company_address = raw.address;
        if (!normalized.company_phone && raw.contact_phone) normalized.company_phone = raw.contact_phone;
        if (!normalized.company_email && raw.contact_email) normalized.company_email = raw.contact_email;
        // Social links
        if (!normalized.social_facebook && raw.social_media_facebook) normalized.social_facebook = raw.social_media_facebook;
        if (!normalized.social_twitter && raw.social_media_twitter) normalized.social_twitter = raw.social_media_twitter;
        if (!normalized.social_instagram && raw.social_media_instagram) normalized.social_instagram = raw.social_media_instagram;
        if (!normalized.social_linkedin && raw.social_media_linkedin) normalized.social_linkedin = raw.social_media_linkedin;
        // Optional SEO keys (fallbacks)
        if (!normalized.site_url && raw.base_url) normalized.site_url = raw.base_url;
        if (!normalized.site_logo_url && raw.logo_url) normalized.site_logo_url = raw.logo_url;
        return normalized;
      }
      throw new Error('Failed to load settings');
    },
    staleTime: 5 * 60 * 1000, // 5 minutes
    // cacheTime: 30 * 60 * 1000, // 30 minutes
    refetchOnWindowFocus: false,
  });

  return {
    settings: data || ({} as SettingsMap),
    loading: isLoading,
    isError,
    error,
    refetch,
  };
}
