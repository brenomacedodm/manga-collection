<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Manga;
use Gate;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MangasController extends Controller implements HasMiddleware
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

        $mangas = Manga::with([
            'authors',
            'genres',
            'publisher' => function ($query) {
                $query->select(['id', 'name']);
            },
            
            ])->where([$conditions])->select('*');
        
        if($request->has('ordering')){
            $mangas->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $mangas->paginate($pageSize);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!$request->isAdmin) return response("You don't have permission to create mangas", 401);
        
        $fields = $request->validate([
            'name'=> 'required|max:255',
            'genre' => 'required',
            'author' => 'required',
            'publisher_id' => 'required',
            'on_going' => 'int',
            'cover' => 'max:255',
            'about' => 'max:255',
            'volumes' => 'required',
        ]);

        $manga = $request->user()->mangas()->create($fields);
        $manga->authors()->attach($request->author);
        $manga->genres()->attach($request->genre);

        for($i = 1;$i <= $manga->volumes; $i++){
            $request->user()->mangaVolumes()->create(['manga_id' => $manga->id, 'number' => $i]);
        }

        return [
            'status' => true,
            'message' => "Manga created successfully"
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Manga $manga)
    {
        return [$manga->load([
            'authors',
            'genres',
            'publisher' => function ($query) {
                $query->select(['id', 'name']);
            }])];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manga $manga)
    {
        
    }
    public function updateAuthors(Request $request, Manga $manga)
    {
        $fields = $request->validate([
            'author' => 'required'
        ]);

        $manga->authors()->sync($fields['author']);
    }
    public function updateGenres(Request $request, Manga $manga)
    {
        $fields = $request->validate([
            'author' => 'required'
        ]);


        $manga->authors()->sync($fields);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mangas $mangas)
    {
        //
    }
}
