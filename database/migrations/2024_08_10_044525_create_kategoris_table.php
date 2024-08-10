<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->text('keterangan')->nullable();
            $table->foreignId('parent_id')->nullable()
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
        Schema::table('kategori', function (Blueprint $table) {
            // Hapus foreign key sebelum menghapus tabel
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('kategori');
    }
}
