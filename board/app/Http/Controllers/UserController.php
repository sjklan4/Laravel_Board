<?php

/************************************
 * 프로젝트명   : laravel_board
 * 디렉토리     : Controllers
 * 파일명       : BoardsController.php
 * 이력         : V001 0530 SJ.Park new            
 ***********************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; //여기 사용해야 되는거 ㅇㄷ서 확인함?
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    function login(){
        return view('login');
    }

    function registration(){
        return view('registration');
    }

    function registrationpost(Request $req){
        // 유효성 체크
        $req->validate([
            'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30' 
            ,'email'    =>  'required|email|max:100'
            ,'password' =>  'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/' //두 값을 비교해서 같은지 확인해 주는 구문
        ]);

        $data['name'] =$req->name;
        $data['email'] = $req->email;
        $data['password'] = Hash::make($req->password);

        $user = User::create($data); // insert - 

        if(!$user){
            $error = '시스템 에러가 발생하여, 회원가입에 실패했습니다.<br>잠시 후에 다시 회원가입을 다시 시도해 주십시오.';
            return redirect()
            ->route('users.registration')
            ->with('error', $error);
        }
        // 회원가입 완료 로그인 페이지로 이동
        return redirect()
            ->route('users.login')
            ->with('success', '회원가입을 완료 했습니다<br>가입하신 아이디와 비밀번호로 로그인해 주십시오.');
    }


    function loginpost(Request $req){
        $req->validate([
            'email'    =>  'required|email|max:100'
            ,'password' =>  'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);
        
        //유저 정보 습득
        $user = User::where('email',$req->email)->first();
        if(!$user || !(Hash::check($req->password, $user->password))){
            $error = '아이디와 비밀번호를 확인해 주세요.';
            return redirect()->back()->with('error',$error);
        }

        // 유저 인증작업
        Auth::login($user);
        if(Auth::check()){
            session($user->only('id')); //세션에 인증된 회원 pk등록
            return redirect()->intended(route('boards.index'));
        } else{
            $error = '인증작업 에러.';
            return redirect()->back()->with('error',$error);
        }
    }

    function logout(){
        session::flush();   //세션 파기
        Auth::logout();     //로그아웃
        return redirect()->route('users.login');
    }

    function withdraw(){
        $id = session('id');
        $result = User::destroy($id);       //탈퇴 확인여부 진행절차 추가 필요 (오류 발생시 처리 구문 - error handling)
        session::flush();
        Auth::logout();
        return redirect()->route('users.login');
    }

    public function useredit(){

        $id = session('id');
        $userinfo = User::FindOrFail($id);
        
        return view('useredit')->with('data', $userinfo);
    }


    public function usereditpost(Request $req){
         //유효성 체크
        // 유효성체크 내용을 담는
        $arrKey = [];
        $baseUser = User::find(Auth::User()->id); //기존 데이터 획득

        //기존 패스워드 체크
        if(Hash::check($req->bpassword, $user->bpassword)){
            redirect()->back()->with('error','기존 비밀번호를 확인해 주세요.');
        }

         // 수정할 항목을 배열에 담는 처리
        if($req->name !== $baseUser->name){
            $arrKey[] = 'name';
        }
        if(isset($req->password)){
            $arrKey[] = 'password';
        }

        //유효성 체크를 하는 모든 항목 리스트
        $chkList = [
            'name'      =>'required|regex:/^[가-힣]+$/|min:2|max:30'
            ,'bpassword'=> 'regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
            ,'password' => 'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ];

        // 유효성 체크할 항목 셋팅하는 처리 - 루프돌리는 기준이 arrkey 이 키는 수정하고자하는 값만 들어 가있다. 
        $arrchk['bpassword'] = $chkList['bpassword'];
        foreach($arrKey as $val){
            $arrchk[$val] = $chkList[$val];
        }

        // 유효성 체크
        $req->validate($arrchk);

        //수정할 데이터 셋팅: 어떻게>? 
        foreach($arrkey as $val){
            if($val === 'password'){
                $baseUser->$val = Hash::make($req->$val);
                continue;
            }
            $baseUser->$val = $req->$val;
        }
        $baseUser->save(); //update
        return redirect()->route('users.edit');

        // return redirect()->route('users.login');


    //내가 한거-------------------------------------------------------------------------
        // if((!($req->name) || !(Hash::check($req->password)))){
        //     $error = '아이디와 비밀번호를 확인해 주세요.';
        //     return redirect()->back()->with('error',$error);
        // }

        // $id = session('id');
        // $userinfo = User::findOrFail($id);
        // $userinfo->email = $req->email;
        // $userinfo->password = Hash::make($req->password);
        // $userinfo->name = $req->name;
        // $userinfo->save();
        // Auth::logout();
        // return redirect()->route('users.login');
    //--------------------------------------------------------------------------------------    
    }


    public function userinfo(){
        $id = session('id');
        $userinfo = User::FindOrFail($id);      //$session id에 담겨있는 모든 정보를 가져 오는 구문 
        return view('userinfo')->with('data', $userinfo);
    }



}
