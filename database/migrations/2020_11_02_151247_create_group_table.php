<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('group');
        Schema::enableForeignKeyConstraints();

        Schema::create('group', function (Blueprint $table) {
            $table->bigInteger('id',true);
            $table->integer('test_id');
            $table->string('name',191);
            $table->integer('stt');
            $table->integer('time')->nullable();
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
        Schema::dropIfExists('group');
        Schema::enableForeignKeyConstraints();
    }
}
