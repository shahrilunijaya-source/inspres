<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('marriage_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('groom_name');
            $table->string('groom_nric', 14);
            $table->string('groom_religion')->nullable();
            $table->string('bride_name');
            $table->string('bride_nric', 14);
            $table->string('bride_religion')->nullable();
            $table->string('witness1_name');
            $table->string('witness1_nric', 14);
            $table->string('witness2_name');
            $table->string('witness2_nric', 14);
            $table->enum('caveat_status', ['pending', 'clear', 'caveat_filed'])->default('pending');
            $table->enum('civil_status_check', ['pending', 'clear', 'flagged'])->default('pending');
            $table->timestamp('appointment_at')->nullable();
            $table->string('appointment_location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marriage_applications');
    }
};
