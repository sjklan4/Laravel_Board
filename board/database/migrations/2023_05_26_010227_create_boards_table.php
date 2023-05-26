<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() //테이블의 설정을 잡아 주는 구문
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
            $table->string('content', 2000);
            $table->integer('hits');
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
        Schema::dropIfExists('boards');
    }
};
