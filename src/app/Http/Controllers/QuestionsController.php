<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\questions;

// use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    public function show(Request $request)
    {

        file_put_contents('test.log', $request->input('newValue'));

        $newValue = $request->input('newValue');





        $res = questions::paginate(20, ['*'], 'page', $newValue);



        return json_encode($res);
    }

    public function save_question(Request $request)
    {

        // $json = $request->input('questions');


        // file_put_contents('test.log', $json[0]);
        $json = json_encode($request->input('questions'));
        file_put_contents('test.log', $json);


        //モデルをインスタンス化


        //モデル->カラム名 = 値 で、データを割り当てる
        // dd($request->input('Deadline'));
        // $task->Deadline = $request->input('Deadline');
        $question = new questions;
        $question->title = $request->input('title');
        $question->category = $request->input('category'); //質問のカテゴリ
        $question->answer_count = 2; //回答回数
        $question->is_solved = 0; //回答済みかどうか
        $question->content = $json; //質問内容
        $question->user_name = $request->input('user_name');
        $question->view_count = 50; //閲覧数
        $question->created_at = now();
        $question->updated_at = now();
        $question->save();
    }

    public function send_question(Request $request)
    {


        // file_put_contents('test.log', $request->input('questions_id'));


        // $id=$request->input('questions_id');


        // // $questions = new questions;
        // $question_data = questions::find($id);

        // // 取り出したデータを返す
        // return response()->json([
        //     'question_data' => $question_data,
        // ]);

        // file_put_contents('test.log', $request->input('questions_id'));

        $id = $request->input('questions_id');

        $question_data = DB::table('questions')->where('id', $id)->first();

        return response()->json([
            'question_data' => $question_data
        ]);
    }

    public function search_send(Request $request)
    {

        // //検索する文字列と現在ページが渡される
        // $search_question = questions::where('name', 'like', '%'.$query.'%')
        //         ->orWhere('email', 'like', '%'.$query.'%')
        //         ->paginate(20, ['*'], 'page', $newValue);
    }
}
