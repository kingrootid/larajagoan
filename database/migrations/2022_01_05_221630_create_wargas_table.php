<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->string('email');
            $table->text('ktp');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status_perkawinan', ['Single', 'Menikah']);
            $table->enum('status_warga', ['Sudah Pindah', 'Warga'])->default('Warga');
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
        Schema::dropIfExists('wargas');
    }
}
