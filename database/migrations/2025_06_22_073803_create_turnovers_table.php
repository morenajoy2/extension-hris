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
        Schema::create('turnovers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Employee Account Turnover
            $table->date('orientation_date')->nullable();
            $table->date('first_day')->nullable();
            $table->date('last_day')->nullable();
            $table->date('exit_day')->nullable();
            $table->integer('worked_hours_required')->nullable();

            // Recommended Employee
            $table->integer('recommended_employee_id')->nullable();
            $table->string('recommended_employee_name')->nullable();
            $table->text('turned_over_tasks')->nullable();

            // File Ownership
            $table->text('company_accounts_transferred')->nullable();
            $table->text('credentials_handed_over')->nullable();

            // Verifications
            $table->integer('team_leader_id')->nullable();
            $table->string('team_leader_name')->nullable();
            $table->integer('corporate_leader_id')->nullable();
            $table->string('corporate_leader_name')->nullable();

            // Signed file
            $table->string('esignature_turnover_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnovers');
    }
};
