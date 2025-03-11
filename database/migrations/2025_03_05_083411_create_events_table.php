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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->date('data')->nullable();
            $table->foreignId('id_institution')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('id_events_category')->constrained('events_category')->onDelete('cascade');
            $table->foreignId('id_subcategory')->nullable()->constrained('events_subcategory')->onDelete('set null');
            $table->integer('persons_involved')->nullable();
            $table->text('events_text')->nullable();
            $table->timestamps();
            $table->index('id_institution', 'idx_events_id_institution');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
