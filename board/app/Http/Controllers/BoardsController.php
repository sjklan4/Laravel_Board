<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // $boards = $request->only(['title','content']);

        $boards =  Boards::find($id);
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
}
