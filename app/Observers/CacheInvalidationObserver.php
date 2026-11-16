<?php

namespace App\Observers;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Model;

class CacheInvalidationObserver
{
    /**
     * Map model classes to the cache keys that must be cleared when changed.
     */
    protected static array $modelCacheMap = [
        \App\Models\HeroBanner::class => [
            CacheService::KEY_HERO_BANNERS,
        ],
        \App\Models\StatCounter::class => [
            CacheService::KEY_STAT_COUNTERS,
        ],
        \App\Models\AboutSection::class => [
            CacheService::KEY_ABOUT_SECTION,
        ],
        \App\Models\PresidentMessage::class => [
            CacheService::KEY_PRESIDENT_MESSAGE,
        ],
        \App\Models\Event::class => [
            CacheService::KEY_HOME_EVENTS,
        ],
        \App\Models\EventPhoto::class => [
            CacheService::KEY_HOME_EVENTS,
        ],
        \App\Models\Notice::class => [
            CacheService::KEY_HOME_NOTICES,
        ],
        \App\Models\NoticeFile::class => [
            CacheService::KEY_HOME_NOTICES,
        ],
        \App\Models\DonationSetting::class => [
            CacheService::KEY_DONATION_SETTING,
        ],
        \App\Models\Post::class => [
            CacheService::KEY_HOME_POSTS,
        ],
        \App\Models\Category::class => [
            CacheService::KEY_HOME_POSTS,
        ],
        \App\Models\Pride::class => [
            CacheService::KEY_HOME_PRIDES,
        ],
        \App\Models\Committee::class => [
            CacheService::KEY_HOME_COMMITTEE,
            CacheService::KEY_ACTIVE_COMMITTEES,
        ],
        \App\Models\CommitteeMember::class => [
            CacheService::KEY_HOME_COMMITTEE,
            CacheService::KEY_ACTIVE_COMMITTEES,
        ],
        \App\Models\SiteSetting::class => [
            CacheService::KEY_SITE_BRANDING,
        ],
        \App\Models\ContactSetting::class => [
            CacheService::KEY_SITE_CONTACT,
        ],
        \App\Models\SocialLink::class => [
            CacheService::KEY_SITE_SOCIAL_LINKS,
        ],
        \App\Models\TopbarSetting::class => [
            CacheService::KEY_SITE_TOPBAR,
        ],
        \App\Models\FooterSetting::class => [
            CacheService::KEY_SITE_FOOTER,
        ],
        \App\Models\Union::class => [
            CacheService::KEY_ACTIVE_UNIONS,
        ],
        \App\Models\NavItem::class => [
            CacheService::KEY_ACTIVE_NAV_TREE,
        ],
        \App\Models\Member::class => [
            CacheService::KEY_ADMIN_DASHBOARD,
        ],
        \App\Models\Volunteer::class => [
            CacheService::KEY_ADMIN_DASHBOARD,
        ],
        \App\Models\Donation::class => [
            CacheService::KEY_ADMIN_DASHBOARD,
        ],
        \App\Models\Project::class => [
            CacheService::KEY_ADMIN_DASHBOARD,
        ],
    ];

    /**
     * Handle created, updated, saved, deleted, restored events.
     */
    public function created(Model $model): void
    {
        $this->invalidate($model);
    }

    public function updated(Model $model): void
    {
        $this->invalidate($model);
    }

    public function deleted(Model $model): void
    {
        $this->invalidate($model);
    }

    public function restored(Model $model): void
    {
        $this->invalidate($model);
    }

    protected function invalidate(Model $model): void
    {
        $class = get_class($model);
        if (isset(self::$modelCacheMap[$class])) {
            CacheService::forget(self::$modelCacheMap[$class]);
        }
    }

    /**
     * Register observer on all specified models
     */
    public static function boot(): void
    {
        foreach (array_keys(self::$modelCacheMap) as $modelClass) {
            if (class_exists($modelClass)) {
                $modelClass::observe(self::class);
            }
        }
    }
}
