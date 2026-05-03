<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certificate_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained()->cascadeOnDelete();
            $table->string('certificate_no', 40);
            $table->string('verification_code', 64)->unique();
            $table->string('verification_url');
            $table->enum('status', ['valid', 'invalid', 'revoked'])->default('valid');
            $table->timestamp('last_verified_at')->nullable();
            $table->unsignedInteger('verify_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_verifications');
    }
};
