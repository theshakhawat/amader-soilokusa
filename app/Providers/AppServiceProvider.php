<?php

namespace App\Providers;

use App\Models\ContactSetting;
use App\Models\FooterSetting;
use App\Models\MailSetting;
use App\Models\NavItem;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\TopbarSetting;
use App\Models\Union;
use App\Models\Committee;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Super Admin & Admin bypass all permissions
        Gate::before(function ($user, $ability) {
            return ($user->hasRole('admin') || $user->hasRole('super-admin')) ? true : null;
        });

        // Dynamically configure Mail settings from database
        MailSetting::applyMailConfig();

        // Boot Auto Cache Invalidation Observer across all models
        \App\Observers\CacheInvalidationObserver::boot();

        // Global Layout View Composer: Request-scoped singleton cache to eliminate duplicate queries across views
        View::composer(['layouts.website.*', 'layouts.admin.*', 'home'], function ($view) {
            static $siteBranding = null;
            static $siteContact = null;
            static $siteSocialLinks = null;
            static $topbarSetting = null;
            static $footerSetting = null;
            static $cachedUnions = null;
            static $cachedCommittees = null;
            static $cachedNavItems = null;

            if ($siteBranding === null) {
                $siteBranding = SiteSetting::first();
            }
            if ($siteContact === null) {
                $siteContact = ContactSetting::first();
            }
            if ($siteSocialLinks === null) {
                $siteSocialLinks = SocialLink::where('is_active', true)->orderBy('order')->orderBy('id')->get();
            }
            if ($topbarSetting === null) {
                $topbarSetting = TopbarSetting::first();
            }
            if ($footerSetting === null) {
                $footerSetting = FooterSetting::first();
            }
            if ($cachedUnions === null) {
                $cachedUnions = Union::where('status', true)->orderBy('order', 'asc')->get();
            }
            if ($cachedCommittees === null) {
                $cachedCommittees = Committee::where('is_active', true)->orderBy('order', 'asc')->get();
            }
            if ($cachedNavItems === null) {
                $cachedNavItems = NavItem::whereNull('parent_id')
                    ->where('status', true)
                    ->with(['activeChildren.activeChildren'])
                    ->orderBy('order', 'asc')
                    ->get();
            }

            $view->with([
                'sharedSiteBranding'    => $siteBranding,
                'sharedSiteContact'     => $siteContact,
                'sharedSiteSocialLinks' => $siteSocialLinks,
                'sharedTopbarSetting'   => $topbarSetting,
                'sharedFooterSetting'   => $footerSetting,
                'sharedActiveUnions'    => $cachedUnions,
                'sharedActiveCommittees'=> $cachedCommittees,
                'sharedNavItems'        => $cachedNavItems,
            ]);
        });
    }
}
