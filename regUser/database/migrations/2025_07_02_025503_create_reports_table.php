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
        Schema::create('reports', function (Blueprint $table) {
    $table->id();
    $table->morphs('reportable'); // creates reportable_id and reportable_type
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // who reported
    $table->string('reason'); // inappropriate, spam, etc.
    $table->timestamps();
            
    $table->unique(['user_id', 'reportable_id', 'reportable_type'], 'unique_report');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
