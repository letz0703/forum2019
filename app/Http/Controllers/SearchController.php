<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show()
    {
        $search = request('q');
        //return Thread::search($search)->get();
        return Thread::search($search)->paginate(25);
    }
    
}
