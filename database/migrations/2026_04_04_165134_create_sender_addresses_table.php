<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sender_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Nama alamat (misal: Kantor Pusat)
            $table->text('address');
            $table->string('contact')->nullable(); // Kontak khusus alamat
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sender_addresses');
    }
};