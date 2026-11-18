<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Whitelist of routes that all authenticated admin panel users can access without specific permissions.
     */
    protected array $publicAdminRoutes = [
        'admin.dashboard',
        'admin.profile',
        'admin.profile.update',
        'admin.profile.password',
        'admin.profile.password.update',
        'admin.notifications.read',
        'admin.notifications.mark-all-read',
        'admin.quick-search',
    ];

    /**
     * Explicit route name to permission mapping.
     */
    protected array $routePermissions = [
        // Cache Optimization (restricted to settings.mail or roles.manage)
        'admin.optimize.cache' => ['settings.mail', 'roles.manage'],

        // Members Management
        'admin.members.index'   => 'members.view',
        'admin.members.show'    => 'members.view',
        'admin.members.create'  => 'members.create',
        'admin.members.store'   => 'members.create',
        'admin.members.edit'    => 'members.edit',
        'admin.members.update'  => 'members.edit',
        'admin.members.status'  => 'members.status',
        'admin.members.approve' => 'members.status',
        'admin.members.export'  => 'members.export',
        'admin.members.destroy' => 'members.delete',

        // Volunteers Management
        'admin.volunteers.index'   => 'volunteers.view',
        'admin.volunteers.show'    => 'volunteers.view',
        'admin.volunteers.create'  => 'volunteers.create',
        'admin.volunteers.store'   => 'volunteers.create',
        'admin.volunteers.edit'    => 'volunteers.edit',
        'admin.volunteers.update'  => 'volunteers.edit',
        'admin.volunteers.status'  => 'volunteers.status',
        'admin.volunteers.approve' => 'volunteers.status',
        'admin.volunteers.export'  => 'volunteers.export',
        'admin.volunteers.destroy' => 'volunteers.delete',

        // Donations Management
        'admin.donations.index'   => 'donations.view',
        'admin.donations.show'    => 'donations.view',
        'admin.donations.create'  => 'donations.create',
        'admin.donations.store'   => 'donations.create',
        'admin.donations.export'  => 'donations.export',
        'admin.donations.destroy' => 'donations.delete',

        // Notices Management
        'admin.notices.index'         => 'notices.view',
        'admin.notices.show'          => 'notices.view',
        'admin.notices.create'        => 'notices.create',
        'admin.notices.store'         => 'notices.create',
        'admin.notices.edit'          => 'notices.edit',
        'admin.notices.update'        => 'notices.edit',
        'admin.notices.status'        => 'notices.edit',
        'admin.notices.destroy'       => 'notices.delete',
        'admin.notices.files.destroy' => 'notices.delete',

        // Events Management
        'admin.events.index'          => 'events.view',
        'admin.events.show'           => 'events.view',
        'admin.events.create'         => 'events.create',
        'admin.events.store'          => 'events.create',
        'admin.events.edit'           => 'events.edit',
        'admin.events.update'         => 'events.edit',
        'admin.events.status'         => 'events.edit',
        'admin.events.destroy'        => 'events.delete',
        'admin.events.photos.destroy' => 'events.delete',

        // Development Projects
        'admin.projects.index'          => 'projects.view',
        'admin.projects.show'           => 'projects.view',
        'admin.projects.create'         => 'projects.create',
        'admin.projects.store'          => 'projects.create',
        'admin.projects.edit'           => 'projects.edit',
        'admin.projects.update'         => 'projects.edit',
        'admin.projects.status'         => 'projects.edit',
        'admin.projects.destroy'        => 'projects.delete',
        'admin.projects.photos.destroy' => 'projects.delete',

        // Committees Management
        'admin.committees.index'          => 'committees.view',
        'admin.committees.show'           => 'committees.view',
        'admin.committees.create'         => 'committees.create',
        'admin.committees.store'          => 'committees.create',
        'admin.committees.edit'           => 'committees.edit',
        'admin.committees.update'         => 'committees.edit',
        'admin.committees.status'         => 'committees.edit',
        'admin.committees.destroy'        => 'committees.delete',
        'admin.committee-members.index'   => 'committees.view',
        'admin.committee-members.show'    => 'committees.view',
        'admin.committee-members.create'  => 'committees.create',
        'admin.committee-members.store'   => 'committees.create',
        'admin.committee-members.edit'    => 'committees.edit',
        'admin.committee-members.update'  => 'committees.edit',
        'admin.committee-members.status'  => 'committees.edit',
        'admin.committee-members.destroy' => 'committees.delete',

        // Blog Posts & Categories
        'admin.posts.index'          => 'posts.view',
        'admin.posts.show'           => 'posts.view',
        'admin.posts.create'         => 'posts.create',
        'admin.posts.store'          => 'posts.create',
        'admin.posts.edit'           => 'posts.edit',
        'admin.posts.update'         => 'posts.edit',
        'admin.posts.status'         => 'posts.edit',
        'admin.posts.destroy'        => 'posts.delete',
        'admin.categories.index'     => 'posts.view',
        'admin.categories.create'    => 'posts.create',
        'admin.categories.store'     => 'posts.create',
        'admin.categories.edit'      => 'posts.edit',
        'admin.categories.update'    => 'posts.edit',
        'admin.categories.status'    => 'posts.edit',
        'admin.categories.destroy'   => 'posts.delete',

        // Gallery Management
        'admin.gallery.index'   => 'gallery.view',
        'admin.gallery.show'    => 'gallery.view',
        'admin.gallery.create'  => 'gallery.create',
        'admin.gallery.store'   => 'gallery.create',
        'admin.gallery.edit'    => 'gallery.edit',
        'admin.gallery.update'  => 'gallery.edit',
        'admin.gallery.status'  => 'gallery.edit',
        'admin.gallery.destroy' => 'gallery.delete',

        // Pride Personalities
        'admin.prides.index'   => 'prides.view',
        'admin.prides.show'    => 'prides.view',
        'admin.prides.create'  => 'prides.create',
        'admin.prides.store'   => 'prides.create',
        'admin.prides.edit'    => 'prides.edit',
        'admin.prides.update'  => 'prides.edit',
        'admin.prides.status'  => 'prides.edit',
        'admin.prides.destroy' => 'prides.delete',

        // Places Management
        'admin.places.index'          => 'places.view',
        'admin.places.show'           => 'places.view',
        'admin.places.create'         => 'places.create',
        'admin.places.store'          => 'places.create',
        'admin.places.edit'           => 'places.edit',
        'admin.places.update'         => 'places.edit',
        'admin.places.status'         => 'places.edit',
        'admin.places.destroy'        => 'places.delete',
        'admin.places.photos.destroy' => 'places.delete',

        // Institutions Directory & Categories
        'admin.institutions.index'             => 'institutions.view',
        'admin.institutions.show'              => 'institutions.view',
        'admin.institutions.create'            => 'institutions.create',
        'admin.institutions.store'             => 'institutions.create',
        'admin.institutions.edit'              => 'institutions.edit',
        'admin.institutions.update'            => 'institutions.edit',
        'admin.institutions.status'            => 'institutions.edit',
        'admin.institutions.destroy'           => 'institutions.delete',
        'admin.institutions.categories.index'  => 'institutions.view',
        'admin.institutions.categories.create' => 'institutions.create',
        'admin.institutions.categories.store'  => 'institutions.create',
        'admin.institutions.categories.edit'   => 'institutions.edit',
        'admin.institutions.categories.update' => 'institutions.edit',
        'admin.institutions.categories.status' => 'institutions.edit',
        'admin.institutions.categories.destroy'=> 'institutions.delete',

        // Offices Directory
        'admin.offices.index'   => 'offices.view',
        'admin.offices.show'    => 'offices.view',
        'admin.offices.create'  => 'offices.create',
        'admin.offices.store'   => 'offices.create',
        'admin.offices.edit'    => 'offices.edit',
        'admin.offices.update'  => 'offices.edit',
        'admin.offices.status'  => 'offices.edit',
        'admin.offices.destroy' => 'offices.delete',

        // Unions Management
        'admin.unions.index'   => 'unions.view',
        'admin.unions.show'    => 'unions.view',
        'admin.unions.create'  => 'unions.create',
        'admin.unions.store'   => 'unions.create',
        'admin.unions.edit'    => 'unions.edit',
        'admin.unions.update'  => 'unions.edit',
        'admin.unions.status'  => 'unions.edit',
        'admin.unions.destroy' => 'unions.delete',

        // Person Messages Management
        'admin.person-messages.index'   => 'person_messages.view',
        'admin.person-messages.show'    => 'person_messages.view',
        'admin.person-messages.create'  => 'person_messages.create',
        'admin.person-messages.store'   => 'person_messages.create',
        'admin.person-messages.edit'    => 'person_messages.edit',
        'admin.person-messages.update'  => 'person_messages.edit',
        'admin.person-messages.status'  => 'person_messages.edit',
        'admin.person-messages.destroy' => 'person_messages.delete',

        // Dynamic Pages Management
        'admin.pages.index'   => 'pages.view',
        'admin.pages.show'    => 'pages.view',
        'admin.pages.create'  => 'pages.create',
        'admin.pages.store'   => 'pages.create',
        'admin.pages.edit'    => 'pages.edit',
        'admin.pages.update'  => 'pages.edit',
        'admin.pages.status'  => 'pages.edit',
        'admin.pages.destroy' => 'pages.delete',

        // Organization Rules & Constitution Management
        'admin.rules.index'   => 'pages.view',
        'admin.rules.show'    => 'pages.view',
        'admin.rules.create'  => 'pages.create',
        'admin.rules.store'   => 'pages.create',
        'admin.rules.edit'    => 'pages.edit',
        'admin.rules.update'  => 'pages.edit',
        'admin.rules.status'  => 'pages.edit',
        'admin.rules.destroy' => 'pages.delete',

        // Contact Messages Management
        'admin.contact-messages.index'       => 'contact_messages.view',
        'admin.contact-messages.show'        => 'contact_messages.view',
        'admin.contact-messages.toggle-read' => 'contact_messages.view',
        'admin.contact-messages.destroy'     => 'contact_messages.delete',

        // Users & Roles Management
        'admin.users.index'            => 'users.view',
        'admin.users.show'             => 'users.view',
        'admin.users.create'           => 'users.create',
        'admin.users.store'            => 'users.create',
        'admin.users.edit'             => 'users.edit',
        'admin.users.update'           => 'users.edit',
        'admin.users.status'           => 'users.edit',
        'admin.users.destroy'          => 'users.delete',
        'admin.roles.index'            => 'roles.manage',
        'admin.roles.store'            => 'roles.manage',
        'admin.roles.update'           => 'roles.manage',
        'admin.roles.destroy'          => 'roles.manage',
        'admin.roles.permissions'        => 'roles.manage',
        'admin.roles.permissions.update' => 'roles.manage',
        'admin.permissions.index'      => 'roles.manage',

        // Mail & System Settings
        'admin.settings.mail'        => 'settings.mail',
        'admin.settings.mail.update' => 'settings.mail',
        'admin.settings.mail.test'   => 'settings.mail',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $permission  Optional explicit permission passed to middleware
     */
    public function handle(Request $request, Closure $next, ?string $permission = null): Response
    {
        $user = $request->user();

        // If not authenticated, let auth middleware handle redirection
        if (!$user) {
            return $next($request);
        }

        // Super-admin or Admin has unrestricted access to all routes
        if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        // If no route name or not an admin route, proceed
        if (!$routeName || !str_starts_with($routeName, 'admin.')) {
            return $next($request);
        }

        // Whitelisted common routes (dashboard, personal profile, notifications, search)
        if (in_array($routeName, $this->publicAdminRoutes, true)) {
            return $next($request);
        }

        // Determine required permission
        $requiredPermission = $permission ?: $this->resolveRequiredPermission($routeName, $request);

        // If a required permission was determined, verify the user has it
        if ($requiredPermission) {
            $hasPermission = false;

            if (is_array($requiredPermission)) {
                foreach ($requiredPermission as $p) {
                    if ($user->can($p)) {
                        $hasPermission = true;
                        break;
                    }
                }
            } else {
                $hasPermission = $user->can($requiredPermission);
            }

            if (!$hasPermission) {
                return $this->handleUnauthorized($request);
            }
        }

        return $next($request);
    }

    /**
     * Resolve the required permission for a given route name.
     */
    protected function resolveRequiredPermission(string $routeName, Request $request): string|array|null
    {
        // 1. Direct match from explicit route map
        if (isset($this->routePermissions[$routeName])) {
            return $this->routePermissions[$routeName];
        }

        // 2. Customization Module Routes (branding, topbar, navbar, about, president, donation, contact, footer, social, banners, counters)
        if (str_starts_with($routeName, 'admin.customization.') ||
            str_starts_with($routeName, 'admin.social-media.') ||
            str_starts_with($routeName, 'admin.hero-banners.') ||
            str_starts_with($routeName, 'admin.stat-counters.')) {

            // Viewing (GET) can be accessed if user has either customization.view or customization.update
            if ($request->isMethod('GET')) {
                return ['customization.view', 'customization.update'];
            }

            // Mutation actions require customization.update
            return 'customization.update';
        }

        // 3. Fallback pattern matching: admin.{module}.{action}
        $parts = explode('.', $routeName);
        if (count($parts) >= 3 && $parts[0] === 'admin') {
            $module = $parts[1];
            $action = end($parts);

            // Standard resource action mapping
            $actionMap = [
                'index'   => 'view',
                'show'    => 'view',
                'create'  => 'create',
                'store'   => 'create',
                'edit'    => 'edit',
                'update'  => 'edit',
                'status'  => 'edit',
                'destroy' => 'delete',
                'export'  => 'export',
            ];

            if (isset($actionMap[$action])) {
                return $module . '.' . $actionMap[$action];
            }
        }

        return null;
    }

    /**
     * Handle an unauthorized access attempt:
     * - For AJAX / JSON: return 403 JSON
     * - For browser navigation: redirect back to admin dashboard or safe previous page with flash error message.
     */
    protected function handleUnauthorized(Request $request): Response
    {
        $message = 'আপনার এই পেজ বা কার্যক্রমে প্রবেশের অনুমতি নেই।';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status'  => 'error',
                'message' => $message,
            ], 403);
        }

        $previous = url()->previous();
        $adminDashboard = route('admin.dashboard');

        // Check if there is a safe previous URL inside the admin area (and not the same forbidden URL)
        if ($previous && $previous !== url()->current() && str_contains($previous, url('/admin'))) {
            return redirect()->to($previous)->with('error', $message);
        }

        // Otherwise safely redirect back to the Admin Dashboard
        return redirect()->route('admin.dashboard')->with('error', $message);
    }
}
