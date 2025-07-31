<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;

class Countercontroller extends Controller
{
    //
    function add(Request $request){
       //create name
        Counter::create(['name' => $request->input('Name'),
    'branch_id' =>'1']);
        return redirect()->back();
    }
}
