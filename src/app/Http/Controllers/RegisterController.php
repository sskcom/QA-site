<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\qasite_users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller

{





  public function register(Request $request)
  {

    $property1 = $request->input('username');
    $property2 = $request->input('email');
    $property3 = $request->input('password');

    // $data = $property1 . $property2 . $property3;

    // file_put_contents('test.log',$data);

    $hashedPassword = Hash::make($request->password);

    // file_put_contents('test.log', $hashedPassword);


    // qasite_users::create([
    //     'username' => $request->username,
    //     'email' => $request->email,
    //     'password' => $hashedPassword,
    //   ]);


    //モデルをインスタンス化
    $users = new qasite_users();

    //モデル->カラム名 = 値 で、データを割り当てる
    // dd($request->input('Deadline'));
    // $task->Deadline = $request->input('Deadline');
    $users->username = $request->input('username');
    $users->email = $request->input('email');
    $users->password = $hashedPassword;






    //データベースに保存
    $users->save();

    return response()->json([
      'hash' => $hashedPassword,
      'email' => $request->email,
      'username' => $request->username,
    ]);
  }

  public function login(Request $request)
  {
    //emailとパスワードを元に、ユーザーをデータベースから検索
    $state = qasite_users::where('email', $request->email)->first();



    if (!$state) {
      // ユーザーが見つからなかった場合、エラーメッセージを返信
      // file_put_contents('test.log',"ユーザが見つかりませんでした");
      return response()->json([
        'error' => 'Invalid email or password.',
      ]);
    }

    // パスワードを検証
    if (!Hash::check($request->password, $state->password)) {
      // パスワードが間違っている場合、エラーメッセージを返信
      // file_put_contents('test.log',"パスワードが間違っていました");
      return response()->json([
        'error' => 'Invalid email or password.',
      ]);
    }

    // ログイン状態を保持するセッションを開始

    Session::start();
    Session::put('user', $state->username);
    // $request->session()->regenerate();
    // $request->session()->put('user', $state->username);

    // ユーザー名を Vue.js に返信
    return response()->json([
      'username' => $state->username,
    ]);
  }

  public function logout(Request $request)
  {
    // セッションを破棄
    // $request->session()->forget('user');
    Session::forget('user');
    // ログアウトに成功したことを Vue.js に返信
    return response()->json([
      'success' => true,
    ]);
  }
}
