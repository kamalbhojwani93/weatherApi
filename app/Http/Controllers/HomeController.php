<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
use Yajra\DataTables\Utilities\Request as DatatableRequest;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('home');
    }

    /**
     * Feeding list of weathers to datatable.
     * @return Response
     */

    public function ajaxList(DatatableRequest $request) 
    {
    	$rows = Weather::orderBy('id', 'desc');
    	if ($request->created_at != '') 
    	{
    		$rows = $rows->whereDate('created_at', '>=', $request->created_at);
    	}
    	$rows = $rows->get();
    	return datatables()->of($rows)
    	->make(true);
    }
}
