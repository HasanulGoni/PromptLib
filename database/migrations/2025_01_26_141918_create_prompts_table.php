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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->string('topic');
            $table->text('prompt_text');
            $table->string('tags')->nullable(); // Comma-separated
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('language')->nullable();
            $table->float('rating')->default(0);
            $table->enum('status', ['active', 'inactive', 'under_review'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
