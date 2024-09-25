<?php

namespace App\Http\Controllers;

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
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name"},
     *                  @OA\Property(property="name", type="string"),
     *              )       
     *          )
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
        if(!$request->isAdmin) return 
        response( 
            [
                "status" => false,
                'message' => "You don't have permission to create genres",
                'data' => []
            ],
             499
        );
        
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
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name"},
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="picture", type="string"),
     *                  @OA\Property(property="publisher_link", type="string"),
     *              )       
     *          )
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
        if(!$request->isAdmin) return 
        response( 
            [
                "status" => false,
                'message' => "You don't have permission to update genres",
                'data' => []
            ],
             499
        );
        
        $fields = $request->validate([
            'name'=> 'required|max:255',
        ]);

        $genre->update($fields);
        return [
            'status' => true,	
            'message' => 'Publisher updated successfully',
            'data' => []
        ];
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
        if(!$request->isAdmin) return 
        response( 
            [
                "status" => false,
                'message' => "You don't have permission to delete genres",
                'data' => []
            ],
             499
        );

        $genre->delete();
        return [
            'status' => true,
            'message' => 'Publisher deleted successfully',
            'data' => []
        ];
    }
}
