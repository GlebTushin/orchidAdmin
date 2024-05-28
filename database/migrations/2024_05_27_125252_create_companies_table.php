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
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('company_id');
            $table->string('company_name');
            $table->string('lat');
            $table->string('lng');
            $table->timestamps();
        });
    
    Schema::table('devices', function (Blueprint $table) {
        $table->unsignedInteger('company_id')->after('vehicle_id')
            ->nullable();

        $table->foreign('company_id')
            ->references('company_id')
            ->on('companies')
            ->onDelete('set null');
    });
    Schema::table('vehicles', function (Blueprint $table) {
        $table->unsignedInteger('company_id')->after('vehicle_id')
            ->nullable();

        $table->foreign('company_id')
            ->references('company_id')
            ->on('companies')
            ->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {Schema::table('devices', function (Blueprint $table) {
        $table->dropForeign('devices_company_id_foreign');
    });
    Schema::table('vehicles', function (Blueprint $table) {
        $table->dropForeign('vehicles_company_id_foreign');
    });
        Schema::dropIfExists('companies');
    }
};
