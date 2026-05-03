<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('cert_no', 40)->unique();
            $table->enum('type', ['birth_cert', 'mykad_slip', 'marriage_cert', 'death_cert', 'adoption_cert', 'citizenship_cert']);
            $table->string('subject_name');
            $table->string('issued_by')->default('Jabatan Pendaftaran Negara');
            $table->date('issued_at');
            $table->string('qr_token', 64)->unique();
            $table->string('preview_path')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
