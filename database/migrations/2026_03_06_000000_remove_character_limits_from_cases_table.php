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
            // Change string columns to text to remove character limits
            $table->text('case_number')->nullable()->change();
            $table->text('docket_no')->nullable()->change();
            $table->text('old_folder_no')->nullable()->change();
            $table->text('case_title')->nullable()->change();
            $table->text('client_name')->nullable()->change();
            $table->text('case_type')->nullable()->change();
            $table->text('section')->nullable()->change();
            $table->text('court_agency')->nullable()->change();
            $table->text('region')->nullable()->change();
            $table->text('assigned_lawyer')->nullable()->change();
            $table->text('handling_counsel_ncip')->nullable()->change();
            $table->text('new_sc_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            // Revert back to string columns
            $table->string('case_number')->nullable()->change();
            $table->string('docket_no')->nullable()->change();
            $table->string('old_folder_no')->nullable()->change();
            $table->string('case_title')->nullable()->change();
            $table->string('client_name')->nullable()->change();
            $table->string('case_type')->nullable()->change();
            $table->string('section')->nullable()->change();
            $table->string('court_agency')->nullable()->change();
            $table->string('region')->nullable()->change();
            $table->string('assigned_lawyer')->nullable()->change();
            $table->string('handling_counsel_ncip')->nullable()->change();
            $table->string('new_sc_no')->nullable()->change();
        });
    }
};
