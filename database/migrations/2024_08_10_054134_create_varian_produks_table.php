<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVarianProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('varian_produk', function (Blueprint $table) {
            $table->id();
            $table->text('keterangan');
            $table->string('harga', 150);
            $table->foreignId('produk_id')->nullable()
                ->constrained('produk')
                ->onDelete('restrict'); // Menambahkan onDelete restrict
            $table->foreignId('varian_id')->nullable()
                ->constrained('varian')
                ->onDelete('restrict'); // Menambahkan onDelete restrict
            $table->foreignId('detail_varian_id')->nullable()
                ->constrained('detail_varian')
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
        Schema::table('varian_produk', function (Blueprint $table) {
            // Hapus foreign key sebelum menghapus tabel
            $table->dropForeign(['produk_id']);
            $table->dropForeign(['varian_id']);
            $table->dropForeign(['detail_varian_id']);
        });
        Schema::dropIfExists('varian_produk');
    }
}
