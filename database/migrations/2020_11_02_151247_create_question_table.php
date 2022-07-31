<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('question');
        Schema::enableForeignKeyConstraints();

        Schema::create('question', function (Blueprint $table) {
            $table->bigInteger('id',true);
            $table->integer('group_id'); // group theo phan thi: phan thi 1, phan thi 2, ...
            $table->integer('stt'); // thu tu cau a/b/c
            $table->longText('content')->nullable();
            $table->integer('time')->nullable();
            $table->integer('audio')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('question');
        Schema::enableForeignKeyConstraints();
    }
}
