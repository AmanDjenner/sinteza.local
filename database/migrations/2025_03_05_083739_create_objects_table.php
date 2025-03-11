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
        Schema::create('objects', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->foreignId('id_institution')->constrained('institutions')->onDelete('cascade');
            $table->string('eveniment', 255)->nullable();
            $table->foreignId('id_obj_list')->nullable()->constrained('object_list')->onDelete('set null');
            $table->text('obj_text')->nullable();
            $table->timestamps();
            $table->index('id_institution', 'idx_objects_id_institution');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objects');
    }
};
