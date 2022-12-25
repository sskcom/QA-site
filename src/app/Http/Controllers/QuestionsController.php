<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\questions;

class QuestionsController extends Controller
{
    public function show(Request $request){

        file_put_contents('test.log',$request->input('newValue'));
    
        $newValue = $request->input('newValue');
    
        
    
       
    
        $res = questions::paginate(20, ['*'], 'page', $newValue);
       
        
    
        return json_encode($res);
    
        
       
        }
}
