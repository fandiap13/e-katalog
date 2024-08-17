<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarnaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->nullable()
                ->constrained('produk')
                ->onDelete('restrict'); // Menambahkan onDelete restrict
            $table->string("warna", 150);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // delete variant product
        Schema::table('warna', function (Blueprint $table) {
            // Hapus foreign key sebelum menghapus tabel
            $table->dropForeign(['produk_id']);
        });

        Schema::dropIfExists('warna');
    }
}
