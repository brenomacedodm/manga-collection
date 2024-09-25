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
     * @OA\Get(
     *     path="/mangas",
     *     tags={"Mangas"},
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
     *          description="List of mangas"
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
     * @OA\Post(
     *     path="/mangas",
     *     security={{"bearerAuth":{}}},
     *     tags={"Mangas"},
     *     summary="Store",
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name"},
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="genre", type="array", @OA\Items(type="integer")),
     *                  @OA\Property(property="author", type="integer"),
     *                  @OA\Property(property="publisher_id", type="integer"),
     *                  @OA\Property(property="on_going", type="boolean"),
     *                  @OA\Property(property="volumes", type="integer")
     *              )       
     *          )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Manga created successfully"
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
                'message' => "You don't have permission to create mangas",
                'data' => []
            ],
            499
        );         

        $fields = $request->validate([
            'name'=> 'required|max:255',
            'genre' => 'array|required',
            'author' => 'required',
            'publisher_id' => 'required',
            'on_going' => 'int',
            'cover' => 'max:255',
            'about' => 'max:255',
            'volumes' => 'required',
        ]);

        return $fields;

        $manga = $request->user()->mangas()->create($fields);
        $manga->authors()->attach($request->author);
        $manga->genres()->attach($request->genre);

        for($i = 1;$i <= $manga->volumes; $i++){
            $request->user()->mangaVolumes()->create(['manga_id' => $manga->id, 'number' => $i]);
        }

        return response()->json([
            'status' => true,
            'message' => "Manga created successfully",
            'data' => []
        ]);
    }

    /**
     * @OA\Get(
     *     path="/mangas/{manga_id}",
     *     tags={"Mangas"},
     *     summary="Show",
     *     @OA\Parameter(
     *          name="manga_id",
     *          in="path",
     *          description="Parameter that filter the entity",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Return the requested manga"
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
    public function show(Manga $manga)
    {
        return response()->json([
            'status' => true,
            'message' => 'Manga found successfully',
            'data' => [
                [
                    $manga->load([
                            'authors',
                            'genres',
                            'publisher'
                    ])
                ]
            ]
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/mangas/{manga_id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Mangas"},
     *     summary="Update",
     *     @OA\Parameter(
     *          name="manga_id",
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
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="on_going", type="int"),
     *                  @OA\Property(property="civer", type="string"),
     *                  @OA\Property(property="about", type="string"),
     *                  @OA\Property(property="volumes", type="string"),
     *              )       
     *          )
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
    public function update(Request $request, Manga $manga)
    {
        if(!$request->isAdmin) return response( 
            [
                "status" => false,
                'message' => "You don't have permission to update mangas",
                'data' => []
            ],
             499
            );        

        $fields = $request->validate([
            'name'=> 'max:255',
            'on_going' => 'int',
            'cover' => 'max:255',
            'about' => 'max:255',
            'volumes' => 'int',
        ]);

        $manga->update($fields);

        return [
            'status' => true,
            'message' => "Manga updated successfully"
        ];
    }
    public function updateAuthors(Request $request, Manga $manga)
    {
        if(!$request->isAdmin) return response("You don't have permission to update mangas", 401);

        $fields = $request->validate([
            'author' => 'required'
        ]);

        $manga->authors()->sync($fields['author']);

        return [
            'status' => true,
            'message' => "Manga updated successfully"
        ];
    }
    public function updateGenres(Request $request, Manga $manga)
    {
        if(!$request->isAdmin) return response("You don't have permission to create mangas", 401);

        $fields = $request->validate([
            'genre' => 'required'
        ]);

        $manga->genre()->sync($fields['genre']);

        return [
            'status' => true,
            'message' => "Manga updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request  $request, Manga $manga)
    {
        if(!$request->isAdmin) return response("You don't have permission to delete mangas", 401);
        
        $manga->delete();
        return [
            'status'=> true,
            'message'=> 'Manga deleted successfully'
        ];

    }
}
