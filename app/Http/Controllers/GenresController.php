<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedAccessException;
use App\Models\Genre;
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
     * @OA\Get(
     *     path="/genres",
     *     tags={"Genres"},
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
     *          description="List of genres"
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
        
        $genres = Genre::select('*')->where([$conditions]);

        if($request->has('ordering')){
            $genres->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $genres->paginate($pageSize);
    }

    /**
     * @OA\Get(
     *     path="/genres/{genre_id}",
     *     tags={"Genres"},
     *     summary="Show",
     *     @OA\Parameter(
     *          name="genre_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Return the requested genre"
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
    public function show(Genre $genre)
    {
        return response()->json([
            'status' => true,
            'message' => "Genre found successfully",
            'data' => [$genre]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/genres",
     *     security={{"bearerAuth":{}}},
     *     tags={"Genres"},
     *     summary="Store",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Action"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Genre created successfully"
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
        $fields = $request->validate([
            'name' => 'required|max:255'
        ]);

        try{
            $request->user()->genres()->create($fields);
        } catch(UnauthorizedAccessException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        }
        return response()->json([
            'status' => true,
            'message' => "Genre created successfully",
            'data' => []
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/genres/{genre_id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Genres"},
     *     summary="Update",
     *     @OA\Parameter(
     *          name="genre_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string"),
     *              required={"name"},
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Genre updated successfully"
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
    public function update(Request $request, Genre $genre)
    {
        
        $fields = $request->validate([
            'name'=> 'required|max:255',
        ]);
        
        try{
            $genre->update($fields);
        } catch(UnauthorizedAccessException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        }

        return response()->json([
            'status' => true,	
            'message' => 'Genre updated successfully',
            'data' => []
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/genres/{genre_id}",
     *     tags={"Genres"},     
     *     security={{"bearerAuth":{}}},
     *     summary="Destroy",
     *     @OA\Parameter(
     *          name="genre_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Genre deleted successfully"
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
    public function destroy(Request $request, Genre $genre)
    {

        try{
            $genre->delete();
        } catch(UnauthorizedAccessException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        }
        return response()->json([
            'status' => true,
            'message' => 'Genre deleted successfully',
            'data' => []
        ]);
    }
}
