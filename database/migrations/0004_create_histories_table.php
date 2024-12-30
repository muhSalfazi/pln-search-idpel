<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->string('no_pelanggan')->default('-');
            $table->string('tarif')->default('-');
            $table->string('daya')->default('-');
            $table->string('jenis_layanan')->default('-');
            $table->string('nomer_meter')->default('-');
            $table->enum('status', ['ada', 'tidak ada']);
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_customer')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
