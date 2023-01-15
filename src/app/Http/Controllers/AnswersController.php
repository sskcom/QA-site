<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\answers;

class AnswersController extends Controller
{
    

    public function save_answer(Request $request)
    {

        // $json = $request->input('questions');


        // file_put_contents('test.log', $json[0]);
        $json = json_encode($request->input('questions'));
        file_put_contents('test.log', $json);


        //モデルをインスタンス化
      

        //モデル->カラム名 = 値 で、データを割り当てる
        // dd($request->input('Deadline'));
        // $task->Deadline = $request->input('Deadline');
        $answer = new answers;
        $answer->question_id = $request->input('仮のid');
        $answer->answer_content = $request->input('仮のcontents ');//回答回数
        $answer->user_name = $request->input('user_name');
        $answer->created_at = now();
        $answer->updated_at= now();
        $answer->save();
        

    



    }

    public function send_question(Request $request)
    {

        
        file_put_contents('test.log', $request->input('questions_id'));


        $id=$request->input('questions_id');


        // $questions = new questions;
        $answer_data = answers::where('questions_id', $id)->get();
    

        // 取り出したデータを返す
        return response()->json([
            'answer_data' => $answer_data,
        ]);
        






    }
}
