<?php

namespace App\Http\Controllers;

use App\Models\RecentSearch;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('github_datatable');
    }

}
