<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("title", 100)
                ->comment("Заголовок альбома");

            $table->string("slug", 100)
                ->comment("Slug альбома");

            $table->text("description")
                ->nullable()
                ->comment("Описание альбома");

            $table->unsignedBigInteger("priority")
                ->default(0)
                ->comment("Вес альбома");

            $table->unsignedBigInteger("image_id")
                ->nullable()
                ->comment("Обложка альбома");

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
        Schema::dropIfExists('albums');
    }
}