<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. notices (status, date, order_index)
        if (Schema::hasTable('notices')) {
            Schema::table('notices', function (Blueprint $table) {
                if (!Schema::hasIndex('notices', 'notices_status_date_idx')) {
                    $table->index(['status', 'date'], 'notices_status_date_idx');
                }
            });
        }

        // 2. events (status, date, order_index)
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                if (!Schema::hasIndex('events', 'events_status_date_idx')) {
                    $table->index(['status', 'date'], 'events_status_date_idx');
                }
            });
        }

        // 3. posts (status, published)
        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                if (!Schema::hasIndex('posts', 'posts_status_published_idx')) {
                    $table->index(['status', 'published'], 'posts_status_published_idx');
                }
                if (!Schema::hasIndex('posts', 'posts_category_status_idx')) {
                    $table->index(['category_id', 'status'], 'posts_category_status_idx');
                }
            });
        }

        // 4. projects (status, project_status, order_index)
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                if (!Schema::hasIndex('projects', 'projects_status_order_idx')) {
                    $table->index(['status', 'order_index'], 'projects_status_order_idx');
                }
            });
        }

        // 5. hero_banners (status, order)
        if (Schema::hasTable('hero_banners')) {
            Schema::table('hero_banners', function (Blueprint $table) {
                if (!Schema::hasIndex('hero_banners', 'hero_banners_status_order_idx')) {
                    $table->index(['status', 'order'], 'hero_banners_status_order_idx');
                }
            });
        }

        // 6. stat_counters (status, order)
        if (Schema::hasTable('stat_counters')) {
            Schema::table('stat_counters', function (Blueprint $table) {
                if (!Schema::hasIndex('stat_counters', 'stat_counters_status_order_idx')) {
                    $table->index(['status', 'order'], 'stat_counters_status_order_idx');
                }
            });
        }

        // 7. prides (status, order_index)
        if (Schema::hasTable('prides')) {
            Schema::table('prides', function (Blueprint $table) {
                if (!Schema::hasIndex('prides', 'prides_status_order_idx')) {
                    $table->index(['status', 'order_index'], 'prides_status_order_idx');
                }
            });
        }

        // 8. unions (status, order)
        if (Schema::hasTable('unions')) {
            Schema::table('unions', function (Blueprint $table) {
                if (!Schema::hasIndex('unions', 'unions_status_order_idx')) {
                    $table->index(['status', 'order'], 'unions_status_order_idx');
                }
            });
        }

        // 9. committees (is_active, order)
        if (Schema::hasTable('committees')) {
            Schema::table('committees', function (Blueprint $table) {
                if (!Schema::hasIndex('committees', 'committees_active_order_idx')) {
                    $table->index(['is_active', 'order'], 'committees_active_order_idx');
                }
            });
        }

        // 10. committee_members (committee_id, status, order)
        if (Schema::hasTable('committee_members')) {
            Schema::table('committee_members', function (Blueprint $table) {
                if (!Schema::hasIndex('committee_members', 'comm_members_comm_status_order_idx')) {
                    $table->index(['committee_id', 'status', 'order'], 'comm_members_comm_status_order_idx');
                }
            });
        }

        // 11. institutions (institution_category_id, status)
        if (Schema::hasTable('institutions')) {
            Schema::table('institutions', function (Blueprint $table) {
                if (!Schema::hasIndex('institutions', 'institutions_cat_status_idx')) {
                    $table->index(['institution_category_id', 'status'], 'institutions_cat_status_idx');
                }
            });
        }

        // 12. offices (status, order)
        if (Schema::hasTable('offices')) {
            Schema::table('offices', function (Blueprint $table) {
                if (!Schema::hasIndex('offices', 'offices_status_order_idx')) {
                    $table->index(['status', 'order'], 'offices_status_order_idx');
                }
            });
        }

        // 13. nav_items (parent_id, status, order)
        if (Schema::hasTable('nav_items')) {
            Schema::table('nav_items', function (Blueprint $table) {
                if (!Schema::hasIndex('nav_items', 'nav_items_parent_status_order_idx')) {
                    $table->index(['parent_id', 'status', 'order'], 'nav_items_parent_status_order_idx');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $drops = [
            'notices' => ['notices_status_date_idx'],
            'events' => ['events_status_date_idx'],
            'posts' => ['posts_status_published_idx', 'posts_category_status_idx'],
            'projects' => ['projects_status_order_idx'],
            'hero_banners' => ['hero_banners_status_order_idx'],
            'stat_counters' => ['stat_counters_status_order_idx'],
            'prides' => ['prides_status_order_idx'],
            'unions' => ['unions_status_order_idx'],
            'committees' => ['committees_active_order_idx'],
            'committee_members' => ['comm_members_comm_status_order_idx'],
            'institutions' => ['institutions_cat_status_idx'],
            'offices' => ['offices_status_order_idx'],
            'nav_items' => ['nav_items_parent_status_order_idx'],
        ];

        foreach ($drops as $tbl => $indexes) {
            if (Schema::hasTable($tbl)) {
                Schema::table($tbl, function (Blueprint $table) use ($indexes) {
                    foreach ($indexes as $idx) {
                        $table->dropIndex($idx);
                    }
                });
            }
        }
    }
};
