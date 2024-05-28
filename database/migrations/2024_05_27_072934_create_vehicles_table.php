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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('vehicle_id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('devices', function (Blueprint $table) {
            $table->unsignedInteger('vehicle_id')->after('device_id')
                    ->nullable();
        
             $table->foreign('vehicle_id')
                ->references('vehicle_id')
                ->on('vehicles')
                ->onDelete('set null');
            });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign('devices_vehicle_id_foreign');
        });
        Schema::dropIfExists('vehicles');
    }
};
