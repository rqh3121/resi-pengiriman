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
            $table->decimal('weight', 8, 2)->nullable()->after('resi_photo');
            $table->decimal('shipping_cost', 12, 2)->nullable()->after('weight');
        });
    }

    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['weight', 'shipping_cost']);
        });
    }
};
