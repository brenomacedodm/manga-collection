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
     * @OA\Get(
     *     path="/authors",
     *     tags={"Authors"},
     *     summary="Index",
     *     @OA\Parameter(
     *          name="ordering",
     *          in="query",
     *          description="Parameter to order results",
     *          required=false,
     *      ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Parameter that set the page",
     *          required=false,
     *      ),
     *     @OA\Parameter(
     *          name="page_size",
     *          in="query",
     *          description="Parameter that set the size of the result collection",
     *          required=false,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="List of authors"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
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
     * @OA\Post(
     *     path="/authors",
     *     security={{"bearerAuth":{}}},
     *     tags={"Authors"},
     *     summary="Store",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Akira Amano"),
     *              @OA\Property(property="picture", type="string", description="Must be a base64 encoded image"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Author created successfully"
     *      ),
     *     @OA\Response(
     *          response=422, 
     *          description="Field Error"
     *      ),
     *     @OA\Response(
     *          response=401, 
     *          description="Not allowed"
     *      ),
     *     @OA\Response(
     *          response=499, 
     *          description="Not allowed"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function store(Request $request)
    {
        if(!$request->isAdmin) return response( 
            [
                "status" => false,
                'message' => "You don't have permission to create authors",
                'data' => []
            ],
             499
            );

        $fields = $request->validate([
            'name'=> 'required|max:255',
            'picture' => 'max:255'
        ]);

        $request->user()->authors()->create($fields);

        return response()->json([
            'status' => true,
            'message' => "Author created successfully",
            'data' => []
        ]);
        
    }

    /**
     * @OA\Get(
     *     path="/authors/{author_id}",
     *     tags={"Authors"},
     *     summary="Show",
     *     @OA\Parameter(
     *          name="author_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Return the requested author"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *      @OA\Response(
     *          response=401, 
     *          description="Not allowed"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function show(Author $author)
    {
        return response()->json([
            'status' => true,
            'message' => "Author found successfully",
            'data' => [$author]
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/authors/{author_id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Authors"},
     *     summary="Update",
     *     @OA\Parameter(
     *          name="author_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", maxLength=255, example="Osamu Tezuka"),
     *              @OA\Property(property="picture", type="string", description="Must be a base64 encoded image"),
     *              required={"name"},
     *           ),
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Author updated successfully"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *     @OA\Response(
     *          response=401, 
     *          description="Not allowed"
     *      ),
     *     @OA\Response(
     *          response=499, 
     *          description="Not allowed"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     *     @OA\Response(
     *          response=500, 
     *          description="Not allowed"
     *      ),
     * )
     */
    public function update(Request $request, Author $authors)
    {
        if(!$request->isAdmin) return 
        response( 
            [
                "status" => false,
                'message' => "You don't have permission to update authors",
                'data' => []
            ],
             499
        );
        
        $fields = $request->validate([
            'name'=> 'required|max:255',
            'picture' => 'max:255'
        ]);

        $authors->update($fields);
        return response()->json([
            'status' => true,	
            'message' => 'Author updated successfully',
            'data' => []
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/authors/{author_id}",
     *     tags={"Authors"},     
     *     security={{"bearerAuth":{}}},
     *     summary="Destroy",
     *     @OA\Parameter(
     *          name="author_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Author deleted successfully"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *      @OA\Response(
     *          response=401, 
     *          description="Not allowed"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function destroy(Request $request, Author $authors)
    {
        if(!$request->isAdmin) return 
        response( 
            [
                "status" => false,
                'message' => "You don't have permission to delete authors",
                'data' => []
            ],
             499
        );
        $authors->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Author deleted successfully',
            'data' => []
        ]);
    }
}
