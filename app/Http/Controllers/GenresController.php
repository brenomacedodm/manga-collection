<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class GenresController extends Controller implements HasMiddleware
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
        
        $genres = Genre::select('*')->where([$conditions]);

        if($request->has('ordering')){
            $genres->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $genres->paginate($pageSize);
    }

        /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return [$genre];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!$request->isAdmin) return response("You don't have permission to create genres", 401);
        
        $fields = $request->validate([
            'name' => 'required|max:255'
        ]);

        $request->user()->genres()->create($fields);
        return [
            'status' => true,
            'message' => "Genre created successfully"
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        Gate::authorize('defaultPolicy', $request->user());
        
        $fields = $request->validate([
            'name'=> 'required|max:255',
        ]);

        $genre->update($fields);
        return [
            'status'=> true,	
            'message'=> 'Publisher updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Genre $genre)
    {
        Gate::authorize('defaultPolicy', $request->user());

        $genre->delete();
        return [
            'status'=> true,
            'message'=> 'Publisher deleted successfully'
        ];
    }
}
