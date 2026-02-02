<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->string('sender_name');
            $table->string('receiver_name');
            $table->text('item_description');
            $table->string('origin');
            $table->string('destination');
            $table->string('current_status');
            $table->date('expected_delivery_date');
            $table->timestamps();

            $table->index('tracking_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
