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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password'); //최소 60자 까지는 해야 암호화가 가능하다. - 데이터 길이는 늘리는것은되도 줄이는것은 불가(지우고 다시) 
            $table->string('name');
            // $talbe->timestamp('email_verified_at')->nullalbe(); //이메일 인증 관련 구문
            $table->rememberToken(); //로그인 유지 기능 elaquent를 사용해서 사용 가능 
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
        Schema::dropIfExists('users');
    }
};
