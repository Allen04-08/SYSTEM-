<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->cascadeOnDelete();
            $table->enum('stage', ['cutting','carving','assembly','sanding','finishing','packaging']);
            $table->enum('status', ['pending','in_progress','completed','blocked'])->default('pending')->index();
            $table->unsignedInteger('planned_quantity')->default(0);
            $table->unsignedInteger('actual_quantity')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['production_order_id','stage']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_stages');
    }
};
