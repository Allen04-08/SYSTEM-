<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->cascadeOnDelete();
            $table->foreignId('stage_id')->nullable()->constrained('production_stages')->nullOnDelete();
            $table->date('report_date');
            $table->unsignedInteger('quantity_completed')->default(0);
            $table->unsignedInteger('quantity_defective')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['production_order_id', 'stage_id', 'report_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_reports');
    }
};
