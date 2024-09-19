<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PublishersController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except:['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $conditions = ['name', 'like', "%"];
        $pageSize = 25;

        if($request->has('search')){
            $conditions = ['name', 'like', "%".$request->search."%"];
        }

        if($request->has("page_size")){
            $pageSize = $request->page_size > 0 ? $request->page_size : 25;
        }
        
        $publishers = Publisher::select('*')->where([$conditions]);

        if($request->has('ordering')){
            $publishers->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $publishers->paginate($pageSize);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!$request->isAdmin) return response("You don't have permission to create publishers", 401);
        
        $fields = $request->validate([
            'name'=> 'required|max:255',
            'publisher_link' => 'max:255'
        ]);

        $request->user()->publishers()->create($fields);
        return [
            'status' => true,
            'message' => "Publisher created successfully"
        ];

    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return [$publisher];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        if(!$request->isAdmin) return response("You don't have permission to update publishers", 401);
        
        $fields = $request->validate([
            'name'=> 'required|max:255',
            'publisher_link' => 'max:255'
        ]);

        $publisher->update($fields);
        return [
            'status'=> true,	
            'message'=> 'Publisher updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Publisher $publisher )
    {
        if(!$request->isAdmin) return response("You don't have permission to delete publishers", 401);

        $publisher->delete();
        return [
            'status'=> true,
            'message'=> 'Publisher deleted successfully'
        ];

    }
}
