<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('citizen_lifecycle_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('event_type', ['birth_registered', 'mykid_issued', 'mykad_issued', 'marriage_registered', 'death_registered']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();
            $table->enum('status', ['completed', 'current', 'future'])->default('future');
            $table->unsignedTinyInteger('order_index')->default(0);
            $table->timestamps();
            $table->index(['user_id', 'order_index']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citizen_lifecycle_events');
    }
};
