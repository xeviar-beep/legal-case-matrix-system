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
        Schema::table('cases', function (Blueprint $table) {
            // Add missing fields that might be in Excel imports
            if (!Schema::hasColumn('cases', 'section')) {
                $table->string('section')->nullable()->after('case_type');
            }
            if (!Schema::hasColumn('cases', 'court_agency')) {
                $table->string('court_agency')->nullable()->after('section');
            }
            if (!Schema::hasColumn('cases', 'region')) {
                $table->string('region')->nullable()->after('court_agency');
            }
            if (!Schema::hasColumn('cases', 'docket_no')) {
                $table->string('docket_no')->nullable()->after('case_number');
            }
            if (!Schema::hasColumn('cases', 'old_folder_no')) {
                $table->string('old_folder_no')->nullable()->after('docket_no');
            }
            if (!Schema::hasColumn('cases', 'assigned_lawyer')) {
                $table->string('assigned_lawyer')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('cases', 'handling_counsel_ncip')) {
                $table->string('handling_counsel_ncip')->nullable()->after('assigned_lawyer');
            }
            if (!Schema::hasColumn('cases', 'actions_taken')) {
                $table->text('actions_taken')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('cases', 'action')) {
                $table->text('action')->nullable()->after('actions_taken');
            }
            if (!Schema::hasColumn('cases', 'issues_grounds')) {
                $table->text('issues_grounds')->nullable()->after('action');
            }
            if (!Schema::hasColumn('cases', 'prayers_relief')) {
                $table->text('prayers_relief')->nullable()->after('issues_grounds');
            }
            if (!Schema::hasColumn('cases', 'new_sc_no')) {
                $table->string('new_sc_no')->nullable()->after('prayers_relief');
            }
            if (!Schema::hasColumn('cases', 'remarks')) {
                $table->text('remarks')->nullable()->after('new_sc_no');
            }
            if (!Schema::hasColumn('cases', 'optional_blank_section')) {
                $table->text('optional_blank_section')->nullable()->after('remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $columns = [
                'section', 'court_agency', 'region', 'docket_no', 'old_folder_no',
                'assigned_lawyer', 'handling_counsel_ncip', 'actions_taken', 
                'action', 'issues_grounds', 'prayers_relief', 'new_sc_no', 
                'remarks', 'optional_blank_section'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('cases', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
