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
        Schema::create('exit_clearances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->enum('exit_type', ['Resignation', 'Termination'])->nullable();
            $table->enum('turnover_by', ['Team Leader', 'Group Leader'])->nullable();
            $table->text('turned_over_tasks')->nullable();

             $table->string('file_leader_confirmation')->nullable(); // file from leader
            $table->string('file_hr_confirmation')->nullable(); // file from HR

            $table->string('esignature_exit_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exit_clearances');
    }
};
