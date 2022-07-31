<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('test');
        Schema::enableForeignKeyConstraints();

        Schema::create('test', function (Blueprint $table) {
            $table->bigInteger('id',true);
            $table->integer('core_id'); // khoa thi
            $table->string('code',191); // ma de thi
            $table->integer('stt');
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
        Schema::dropIfExists('test');
        Schema::enableForeignKeyConstraints();
    }
}
