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
    Schema::table('devices', function (Blueprint $table) {
        $table->string('external_id')->after('name')->nullable();
        $table->string('phone_number')->after('external_id')->nullable();
        $table->string('status', 30)->after('phone_number')->nullable();
        $table->mediumText('comment')->after('status')->nullable();
        $table->timestamp('last_ping_at')->after('comment')->nullable();
   
    });
    Schema::table('vehicles', function (Blueprint $table) {
        $table->string('speed', 20)->after('name');
        $table->string('number', 20)->after('speed');
        $table->decimal('lat', 12, 9)->after('number')->nullable();
        $table->decimal('lng', 12, 9)->after('lat')->nullable();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void{
    Schema::table('devices', function (Blueprint $table) {
        $table->dropColumn('external_id');
        $table->dropColumn('phone_number');
        $table->dropColumn('status');
        $table->dropColumn('comment');
        $table->dropColumn('last_ping_at');
    });
    Schema::table('vehicles', function (Blueprint $table) {
        $table->dropColumn('speed');
        $table->dropColumn('number');
        $table->dropColumn('lat');
        $table->dropColumn('lng');
    });
    }
};
