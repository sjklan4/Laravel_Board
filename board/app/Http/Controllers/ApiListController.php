<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\Validator;

class ApiListController extends Controller
{
    function getlist($id){
        $boards = Boards::find($id);
        return response()->json($boards,200);

    }
    
    function postlist(Request $req){
        // 유효성 체크 필요

        $boards = new Boards([
            'title' => $req->title
            ,'content' => $req->content
        ]);
        $boards->save();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = $boards->only('id','title');

        return $arr;
    }

    function putlist(Request $req, $id){
        
        //유효성 체크
        // $arr = ['id' => $id];
        // $req->merge($arr); 

        // $validator = Validator::make($req->only('id','title','content'), [
        //     'id'        => 'required|integer' //numeric : integer로도 가능하나 같은 의미에서 정수로만 한다. 라는 의미로 사용
        //     ,'title'    => 'required|between:3,30'
        //     ,'content'  => 'required|max:2000'
        // ]);

        // if ($validator->fails()) {
        //     $reponse = ['error' => '오류 1404'];
        //     return response()->json($reponse,200);
        // }

        // $boards =  Boards::findOrFail($id);
        // $boards->title = $req->title;
        // $boards->content = $req->content;

        // $boards->save();

        // $arr['errorcode'] = '0';
        // $arr['msg'] = 'success';
        // $arr['data'] = $boards->only('id','content');  //여기 왜 id를 조회해야 됨? data는 왜 content를 지정했는데 title도 같이 들어가지?
        // return $arr;


        //유효성 체크 2
        $arrData = [
            'code' => '0'
            ,'msg'  => ''
        
            // ,'upt_data' => []
        ];

        $data = $req->only('title', 'content');
        $data['id'] = $id;

        //유효성 체크구문
        $validator = Validator::make($data,[
            'id' => 'required|integer|exists:boards'
            ,'title' => 'required|between:3,30'
            ,'content' => 'required|max:2000'
        ]);

        if($validator->fails()){
            $arrData['code'] = 'E01';
            $arrData['msg'] = 'Validate Error';
            $arrData['errmsg'] = $validator->errors()->all();
              //라라벨에서 배열을 리턴시키면 자동으로 json으로 변경되서 보내 준다. 
        } else{
             //업데이트 처리
            $boards =  Boards::findOrFail($id);
            $boards->title = $req->title;
            $boards->content = $req->content;
            $boards->save();
            $arrData['code'] = '0';  //위에 먼저 설정되어 있으나 추가적인 확인을 위해서 입력함.
            $arrData['msg'] = 'Success';
        }
        return $arrData; 

    }



    function deletelist($id){
        $arrData = [
            'code' => '0'
            ,'msg'  => ''
            // ,'upt_data' => []
        ];

        $data = ['id' => $id];
        $validator = Validator::make($data, [
            'id'        => 'required|integer' //numeric : integer로도 가능하나 같은 의미에서 정수로만 한다. 라는 의미로 사용
        ]);

        if ($validator->fails()) {
            $arrData['code'] = '1404';
            $arrData['msg'] = '틀림 다시!';
            // return response()->json($reponse,200);
        }
        else{
        $boards = Boards::find($id);
        if($boards){                 //softdelete가 되지 않아서 확인을 위해서 추가한 if구문 
            $boards->delete(); 
            $arrData['errorcode'] = '0';
            $arrData['msg'] = 'success';
            } else{
                $arrData['code'] = 'E02';
                $arrData['msg'] = 'Already Deleted';
            }
        }
        return $arrData;
    }

}
