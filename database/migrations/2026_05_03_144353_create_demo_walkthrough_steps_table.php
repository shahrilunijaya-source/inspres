<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demo_walkthrough_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('step_no')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('route_name')->nullable();
            $table->string('route_url')->nullable();
            $table->text('presenter_notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_walkthrough_steps');
    }
};
