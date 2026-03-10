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
            $table->string('case_number')->nullable()->change();
            $table->string('case_title')->nullable()->change();
            $table->string('client_name')->nullable()->change();
            $table->date('date_filed')->nullable()->change();
            $table->integer('deadline_days')->nullable()->change();
            $table->date('deadline_date')->nullable()->change();
            $table->string('section')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->string('case_number')->nullable(false)->change();
            $table->string('case_title')->nullable(false)->change();
            $table->string('client_name')->nullable(false)->change();
            $table->date('date_filed')->nullable(false)->change();
            $table->integer('deadline_days')->default(15)->nullable(false)->change();
            $table->date('deadline_date')->nullable(false)->change();
            $table->string('section')->nullable(false)->change();
        });
    }
};
