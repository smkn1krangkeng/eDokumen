<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myfiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('filetype', ['Document', 'Picture','Video']);
            $table->string('path');
            $table->boolean('is_public')->default(false);
            $table->foreignId('filecategory_id')->unsigned()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->unsigned()->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('myfiles');
    }
}
