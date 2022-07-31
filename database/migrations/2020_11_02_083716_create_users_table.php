<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_users');
        Schema::enableForeignKeyConstraints();

        Schema::create('m_users', function (Blueprint $table) {
            $table->bigInteger('id',true);
            $table->string('mail', 191);
            $table->string('password',64);
            $table->string('name', 191);
            $table->tinyInteger('role')->comment('1: admin system, 2: teacher, 3: student');
            $table->integer('test_id')->nullable(); // de lay bai thi
            $table->integer('code')->nullable(); // de lay ma de thi
            $table->longtext('remember_token')->nullable();
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
        Schema::dropIfExists('m_users');
        Schema::enableForeignKeyConstraints();
    }
}
