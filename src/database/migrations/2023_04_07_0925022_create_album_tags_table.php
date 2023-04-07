<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_tags', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug")
                ->unique();
            $table->string('main_image')
                ->nullable();
            $table->longText("description")
                ->nullable();
            $table->unsignedBigInteger("priority")
                ->default(0)
                ->comment('Приоритет');
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
        Schema::dropIfExists('album_tags');
    }
}
