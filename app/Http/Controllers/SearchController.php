<?php

namespace App\Http\Controllers;

use App\Models\RecentSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RecentSearch::all();
        return view('search_list', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $repoSearch = $request->get('repo_search');
            $recentSearch = new RecentSearch();
            $recentSearch->repo_search = $repoSearch;
            $recentSearch->save();
            return response()->json(['status' => 'ok']);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => 'Error during save recent search value: '.$ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecentSearch $recentSearch
     * @return \Illuminate\Http\Response
     */
    public function show(RecentSearch $recentSearch)
    {
        //
    }

}
