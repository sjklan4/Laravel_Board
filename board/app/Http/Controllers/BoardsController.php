<?php
/************************************
 * 프로젝트명   : laravel_board
 * 디렉토리     : Controllers
 * 파일명       : BoardsController.php
 * 이력         : V001 0526 SJ.Park new
 *                V002 0530 SJ.Park 유효성 체크 추가
 ***********************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Validator; //v002 and
use App\Models\boards;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //데이터를 받아오기 위한 구문 작성
    {
        //로그인 체크 - 로그인이 되어야만 들어 갈수 있도록 하는구문 

        if(auth()->guest()){
            return redirect()->route('users.login');
        }

        
        $result = boards::select(['id','title','hits','created_at','updated_at'])->orderBy('hits','desc')->get();
        return view('list')->with('data', $result); // 뷰에 데이터를 보내주기 위해서 with문을 사용한다.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('write');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {   
        // v002 add start : 유효성 체크를 위한 구문
        $req->validate([
            'title' => 'required|between:3,30'
            ,'content' => 'required|max:2000'
        ]);
        // v002 add end

        $boards = new Boards([
            'title' => $req->input('title')
            ,'content' => $req->input('content')
        ]);
        $boards->save(); //위 내용을 인서트 시키는 구문
        return redirect('/boards'); //url로 돌아가는 구문 - 작성이 완료되면 list인 메인 페이지로 보내주는 구문
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //조회수 에따른 변경을 위한 구문
    {
        $boards = Boards::find($id); //boards의 모든 데이터를 가져와서 $id부분을 조회 해당하는 값에 대해서 아래의 절차를 진행한다. 
        $boards->hits++; //기존 값에서 hits부분을 가져와서 ++로 해주고 
        $boards->save(); // save 시켜서 업데이트를 시킨다.

        return view('detail')->with('data', Boards::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boards = Boards::findOrFail($id);
        return view('edit')->with('data', $boards);
        
        // return view('edit')->with('data', Boards::findOrFail($id)); //save는 처음에는 insert를 하고 실패시 update를 자동으로 실행한다. 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ********************v002 add start************************** : 유효성 체크를 위한 구문
        
        // $boards = $request->only(['title','content']);
        // $validated = $request->validate([
        //     'title' => 'required|between:3,30'
        //     ,'content' => 'required|max:2000'
        // ]);
        // $validated = $id->validate({'id' => });

        $arr = ['id' => $id];
        $request->merge($arr); // = $request ->request->add($arr); 과 같은 기능 속도차

        $request->validate([
            'id'        => 'required|integer' //numeric : integer로도 가능하나 같은 의미에서 정수로만 한다. 라는 의미로 사용
            ,'title'    => 'required|between:3,30'
            ,'content'  => 'required|max:2000'
        ]);

        // ********************v002 add end**************************

    //------------------------------------------------------------------------------------------------------------------
        //유효성 검사 2
        // $arr = ['id' => $id];
        // $request->merge($arr); 
        // $validator = Validator::make(
        //     $request->only('id','title','content')
        //     ,[
        //         'id' => 'required|integer'
        //         ,'title' => 'required|between:3,30'
        //         ,'content' => 'required|max:2000'
        //     ]
        // );

        //if($validator->fails()){
        //    return redirect() -> back()->withErrors($validator)->withInput(); // 직역 : 오류발생시 reidrect시키는데 돌아가는(back)시크는 값 안에 error를 보내주고 기존 값을 유지하기위해서 withInput을 추가
        //}
    //------------------------------------------------------------------------------------------------------------------
        $boards =  Boards::findOrFail($id);
        $boards->title = $request->title;
        $boards->content = $request->content;

        $boards->save();
        return redirect('/boards/'.$id);
        //return view('detail')->with('data', Boards::findOrFail($id));
        //return redirect()->route('boards.show',['board' => $id]);
    }

    // public function delete(Request $req)
    // {
       
    //     $boards = Boards::find($id);  
    //     $boards->delete_at->$date; 
    //     $boards->save(); 

    //     return redirect('/boards');

    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $boards = Boards::find($id);  
        $boards->delete(); 

        return redirect('/boards');
    }

    // // 로그아웃 method화 
    // public function loginchk(){
    //     if(auth()->guest()){
    //         return redirect()->route('users.login');
    //     }

    // }
}
