<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class AuthorsController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except:['index', 'show'])
        ];
    }


    /**
     * @SWG\Get(
     *     path="/authors",
     *     summary="Get a list of authors",
     *     tags={"Authors"},
     *     @SWG\Response(response=200, description="list of authors"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
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
        
        $author = Author::select('*')->where([$conditions]);

        if($request->has('ordering')){
            $author->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $author->paginate($pageSize);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!$request->isAdmin) return response("You don't have permission to create authors", 401);

        $fields = $request->validate([
            'name'=> 'required|max:255',
            'picture' => 'max:255'
        ]);

        $request->user()->authors()->create($fields);
        return [
            'status' => true,
            'message' => "Author created successfully"
        ];
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return [$author];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $authors)
    {
        if(!$request->is_admin) return response("You don't have permission to update authors", 401);

        
        $fields = $request->validate([
            'name'=> 'required|max:255',
            'publisher_link' => 'max:255'
        ]);

        $authors->update($fields);
        return [
            'status'=> true,	
            'message'=> 'Author updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Author $authors)
    {
        if(!$request->is_admin) return response("You don't have permission to delete authors", 401);

        $authors->delete();
        return [
            'status'=> true,
            'message'=> 'Author deleted successfully'
        ];
    }
}
