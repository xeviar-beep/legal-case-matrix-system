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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->string('case_title');
            $table->string('client_name');
            $table->string('case_type')->nullable();
            $table->date('date_filed');
            $table->integer('deadline_days')->default(15); // e.g., 15, 30, 60 days
            $table->date('deadline_date'); // Auto-calculated
            $table->date('hearing_date')->nullable();
            $table->enum('status', ['active', 'due_soon', 'overdue', 'completed', 'archived'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who created/handles the case
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
