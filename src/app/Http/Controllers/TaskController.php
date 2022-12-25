<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Result;

class TaskController extends Controller

{


    


    public function show(Request $request){

    file_put_contents('test.log',$request->input('newValue'));

    $newValue = $request->input('newValue');

    

   

    $res = Task::paginate(5, ['*'], 'page', $newValue);
   
    

    return json_encode($res);

    
   
    }
}
