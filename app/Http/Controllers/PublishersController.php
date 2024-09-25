<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedAccessException;
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
     * @OA\Get(
     *     path="/publishers",
     *     tags={"Publishers"},
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
     *          description="List of publishers"
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
        
        $publishers = Publisher::select('*')->where([$conditions]);

        if($request->has('ordering')){
            $publishers->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $publishers->paginate($pageSize);

    }

    /**
     * @OA\Post(
     *     path="/publishers",
     *     security={{"bearerAuth":{}}},
     *     tags={"Publishers"},
     *     summary="Store",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Panini Mangas"),
     *              @OA\Property(property="publisher_link", type="string", example="https://paninimangas.com.br"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Publisher created successfully"
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
            'name'=> 'required|max:255',
            'publisher_link' => 'max:255'
        ]);

        try{
            $request->user()->publishers()->create($fields);
        } catch(UnauthorizedAccessException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        }

        return response()->json([
            'status' => true,
            'message' => "Publisher created successfully",
            'data' => []
        ]);

    }

    /**
     * @OA\Get(
     *     path="/publishers/{publisher_id}",
     *     tags={"Publishers"},
     *     summary="Show",
     *     @OA\Parameter(
     *          name="publisher_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Return the requested publisher"
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
    public function show(Publisher $publisher)
    {
        return response()->json([
            'status' => true,
            'message' => "Publisher found successfully",
            'data' => [$publisher]
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/publishers/{publisher_id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Publishers"},
     *     summary="Update",
     *     @OA\Parameter(
     *          name="publisher_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="publisher_link", type="string"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Publisher updated successfully"
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
    public function update(Request $request, Publisher $publisher)
    {     
        $fields = $request->validate([
            'name'=> 'required|max:255',
            'publisher_link' => 'max:255'
        ]);

        try {
            $publisher->update($fields);
        } catch(UnauthorizedAccessException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        }
        
        return response()->json([
            'status'=> true,	
            'message'=> 'Publisher updated successfully',
            'data' => []
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/publishers/{publisher_id}",
     *     tags={"Publishers"},     
     *     security={{"bearerAuth":{}}},
     *     summary="Destroy",
     *     @OA\Parameter(
     *          name="publisher_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Publisher deleted successfully"
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
    public function destroy(Request $request, Publisher $publisher )
    {
        try{
            $publisher->delete();
        } catch(UnauthorizedAccessException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        }
        return response()->json([
            'status'=> true,
            'message'=> 'Publisher deleted successfully',
            'data' => []
        ]);

    }
}
