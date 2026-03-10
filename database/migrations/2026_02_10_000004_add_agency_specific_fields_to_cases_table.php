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
            // SC-specific fields
            $table->text('action')->nullable();
            $table->text('issues_grounds')->nullable();
            $table->text('prayers_relief')->nullable();
            $table->string('new_sc_no')->nullable();
            $table->text('remarks')->nullable();
            $table->text('optional_blank_section')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn([
                'action',
                'issues_grounds',
                'prayers_relief',
                'new_sc_no',
                'remarks',
                'optional_blank_section'
            ]);
        });
    }
};
