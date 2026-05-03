<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('birth_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('child_name');
            $table->enum('child_gender', ['lelaki', 'perempuan']);
            $table->date('child_dob');
            $table->time('child_time_of_birth')->nullable();
            $table->string('hospital');
            $table->string('place_of_birth')->nullable();
            $table->string('father_name');
            $table->string('father_nric', 14);
            $table->string('mother_name');
            $table->string('mother_nric', 14);
            $table->string('marriage_cert_no')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('birth_applications');
    }
};
