<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * composer require doctrine/dbal : 패키지 관리자 설치
     * @return void
     */
    public function up() //db를 어떻게 해서 올릴지 작성하는 구문
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->integer('hits')->default(0)->change(); //hits의 값을 디폴트로 0을 주려고 한다.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
