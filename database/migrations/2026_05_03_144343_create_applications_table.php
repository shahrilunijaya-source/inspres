<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('app_no', 30)->unique();
            $table->enum('module', ['birth', 'mykad', 'marriage', 'death', 'adoption', 'citizenship']);
            $table->foreignId('applicant_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', [
                'draft', 'submitted', 'payment_pending', 'payment_completed',
                'doc_review', 'officer_review', 'approved',
                'cert_generated', 'completed', 'rejected'
            ])->default('draft');

            $table->enum('priority_level', ['high', 'medium', 'normal'])->default('normal');
            $table->timestamp('sla_due_at')->nullable();
            $table->enum('sla_status', ['on_track', 'due_soon', 'breach_risk', 'breached'])->default('on_track');
            $table->timestamp('estimated_completion_at')->nullable();
            $table->unsignedTinyInteger('demo_current_step')->default(1);

            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('assigned_officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by_officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('officer_remarks')->nullable();
            $table->timestamps();

            $table->index(['module', 'status']);
            $table->index('sla_status');
            $table->index('priority_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
