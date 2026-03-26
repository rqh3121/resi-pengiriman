<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('resi_number')->nullable()->after('package_count');
            $table->string('expedition')->nullable()->after('resi_number');
            $table->string('resi_photo')->nullable()->after('expedition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            //
        });
    }
};
