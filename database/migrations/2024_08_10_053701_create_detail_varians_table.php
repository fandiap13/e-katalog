<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailVariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_varian', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->text('keterangan')->nullable();
            $table->foreignId('varian_id')->nullable()
                ->constrained('varian')
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
        Schema::table('detail_varian', function (Blueprint $table) {
            // Hapus foreign key sebelum menghapus tabel
            $table->dropForeign(['varian_id']);
        });
        Schema::dropIfExists('detail_varian');
    }
}
