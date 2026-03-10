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
        Schema::create('import_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_log_id')->constrained('import_logs')->onDelete('cascade');
            $table->integer('row_number');
            $table->string('case_number')->nullable();
            $table->string('case_title')->nullable();
            $table->string('error_type'); // 'missing_required', 'duplicate', 'invalid_data', 'conflict'
            $table->text('error_message');
            $table->json('row_data')->nullable(); // Store the original row data
            $table->timestamps();

            $table->index('import_log_id');
            $table->index('error_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_errors');
    }
};
