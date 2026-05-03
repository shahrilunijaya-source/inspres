<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['public', 'officer', 'supervisor', 'admin'])->default('public')->after('email');
            $table->string('nric', 14)->nullable()->unique()->after('role');
            $table->string('phone', 20)->nullable()->after('nric');
            $table->foreignId('branch_id')->nullable()->after('phone')->constrained()->nullOnDelete();
            $table->boolean('is_demo')->default(false)->after('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['role', 'nric', 'phone', 'branch_id', 'is_demo']);
        });
    }
};
