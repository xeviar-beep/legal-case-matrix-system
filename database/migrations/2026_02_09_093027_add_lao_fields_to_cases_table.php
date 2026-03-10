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
            $table->string('docket_no')->nullable()->after('case_number');
            $table->string('assigned_lawyer')->nullable()->after('user_id');
            $table->enum('section', ['Criminal', 'Civil', 'Labor', 'Administrative', 'Special/IP', 'OJ'])->default('Civil')->after('case_type');
            $table->enum('court_agency', ['SC', 'CA', 'RTC', 'OMB', 'NCIP', 'Other'])->nullable()->after('section');
            $table->enum('region', ['NCR', 'Region I', 'Region II', 'Region III', 'Region IV-A', 'Region IV-B', 'Region V', 'Region VI', 'Region VII', 'Region VIII', 'Region IX', 'Region X', 'Region XI', 'Region XII', 'Region XIII', 'BARMM'])->nullable()->after('court_agency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn(['docket_no', 'assigned_lawyer', 'section', 'court_agency', 'region']);
        });
    }
};
