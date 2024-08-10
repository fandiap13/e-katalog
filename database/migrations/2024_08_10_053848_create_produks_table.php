<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('gambar', 200)->nullable();
            $table->string('harga', 150);
            $table->text('keterangan')->nullable();
            $table->foreignId('kategori_id')->nullable()
                ->constrained('kategori')
                ->onDelete('restrict'); // Menambahkan onDelete restrict
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
        Schema::table('produk', function (Blueprint $table) {
            // Hapus foreign key sebelum menghapus tabel
            $table->dropForeign(['kategori_id']);
        });
        Schema::dropIfExists('produk');
    }
}
