<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->string('status_title');
            $table->string('location');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('shipment_id')
                ->references('id')
                ->on('shipments')
                ->onDelete('cascade');

            $table->index('shipment_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_updates');
    }
};
