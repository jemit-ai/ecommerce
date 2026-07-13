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
        Schema::create('order_timelines', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            
            $table->string('status');        // pending, processing, shipped, delivered, cancelled
            $table->string('title');         // concise title
            $table->text('description')
            ->nullable();                  // detailed explanation (optional)
            
            // who created this event?
            $table->foreignId('created_by')->nullable(); 
            // nullable so OrderPlaced can run without user yet
            
            // optional: make event time explicit (good for timezones)
            $table->timestamp('event_time')->useCurrent();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_timelines');
    }
};
