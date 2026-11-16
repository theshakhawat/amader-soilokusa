<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache tag or key prefixes
     */
    const KEY_HERO_BANNERS       = 'site_hero_banners';
    const KEY_STAT_COUNTERS      = 'site_stat_counters';
    const KEY_ABOUT_SECTION      = 'site_about_section';
    const KEY_PRESIDENT_MESSAGE  = 'site_president_message';
    const KEY_HOME_EVENTS        = 'site_home_events';
    const KEY_HOME_NOTICES       = 'site_home_notices';
    const KEY_DONATION_SETTING   = 'site_donation_setting';
    const KEY_HOME_POSTS         = 'site_home_posts';
    const KEY_HOME_PRIDES        = 'site_home_prides';
    const KEY_HOME_COMMITTEE     = 'site_home_committee';

    const KEY_SITE_BRANDING      = 'site_branding_setting';
    const KEY_SITE_CONTACT       = 'site_contact_setting';
    const KEY_SITE_SOCIAL_LINKS  = 'site_social_links_active';
    const KEY_SITE_TOPBAR        = 'site_topbar_setting';
    const KEY_SITE_FOOTER        = 'site_footer_setting';
    const KEY_ACTIVE_UNIONS      = 'site_active_unions';
    const KEY_ACTIVE_COMMITTEES  = 'site_active_committees';
    const KEY_ACTIVE_NAV_TREE    = 'site_active_nav_tree';

    const KEY_ADMIN_DASHBOARD    = 'admin_dashboard_metrics';

    /**
     * Cache TTL in seconds (e.g. 24 hours).
     * Any update instantly invalidates the relevant key.
     */
    const TTL = 86400;

    /**
     * Invalidate specific keys
     */
    public static function forget(string|array $keys): void
    {
        $keys = is_array($keys) ? $keys : [$keys];
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Clear all website public and chrome caches
     */
    public static function clearAll(): void
    {
        self::forget([
            self::KEY_HERO_BANNERS,
            self::KEY_STAT_COUNTERS,
            self::KEY_ABOUT_SECTION,
            self::KEY_PRESIDENT_MESSAGE,
            self::KEY_HOME_EVENTS,
            self::KEY_HOME_NOTICES,
            self::KEY_DONATION_SETTING,
            self::KEY_HOME_POSTS,
            self::KEY_HOME_PRIDES,
            self::KEY_HOME_COMMITTEE,
            self::KEY_SITE_BRANDING,
            self::KEY_SITE_CONTACT,
            self::KEY_SITE_SOCIAL_LINKS,
            self::KEY_SITE_TOPBAR,
            self::KEY_SITE_FOOTER,
            self::KEY_ACTIVE_UNIONS,
            self::KEY_ACTIVE_COMMITTEES,
            self::KEY_ACTIVE_NAV_TREE,
            self::KEY_ADMIN_DASHBOARD,
        ]);
    }
}
