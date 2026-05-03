<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mykad_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['first_time', 'replacement', 'renewal', 'mykid_to_mykad']);
            $table->string('full_name');
            $table->string('nric', 14);
            $table->date('dob');
            $table->string('reason')->nullable();
            $table->string('photo_path')->nullable();
            $table->enum('biometric_status', ['pending', 'captured', 'verified', 'mismatch'])->default('pending');
            $table->enum('blacklist_check', ['pending', 'clear', 'flagged'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mykad_applications');
    }
};
