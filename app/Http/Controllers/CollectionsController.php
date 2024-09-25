<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CollectionVolume;
use App\Models\MangaVolume;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class CollectionsController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth:sanctum')
        ];
    }

    /**
     * @OA\Get(
     *     path="/collections",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},
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
     *     @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="Parameter that filter the name of the mangas in youe collection",
     *          required=false,
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="List of mangas in your collection"
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
    public function index(Request $request){

        $collection = $request->user()->collection->mangas();
        $collectionId = $request->user()->collection['id'];

        $conditions = "%";
        $pageSize = 25;

        if($request->has('search')){
            $conditions = $request->search;
        }

        if($request->has("page_size")){
            $pageSize = $request->page_size > 0 ? $request->page_size : 25;
        }

        $mangas = $collection->with([
            'authors',
            'genres',
            'publisher',
            ])->withCount([
                'volumes',
                'volumes as owned_volumes' => function ($query) use ($collectionId) {
                    $query->whereExists(function ($subquery) use ($collectionId) {
                        $subquery->select(DB::raw(1))
                            ->from('collection_volume')
                            ->whereColumn('collection_volume.manga_volume_id', 'manga_volumes.id')
                            ->whereColumn('collection_volume.collection_manga_id', 'collection_manga.id')
                            ->where('collection_manga.collection_id', $collectionId);
                    });
                }
            ])->whereName($conditions)->select('*');
        
        if($request->has('ordering')){
            $mangas->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $mangas->paginate($pageSize);

    }
    
    /**
     * @OA\Get(
     *     path="/collections/{manga_id}",
     *     tags={"Collections"},
     *     security={{"bearerAuth":{}}},
     *     summary="Index",
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
     *          description="List all volumes of a mangas and indicates if each is in your collection"
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
    public function show(Request $request, $manga){
        $collection = $request->user()->collection->mangas()->where('mangas.id', $manga);
        $collectionId = $request->user()->collection['id'];

        $conditions = "%";
        $pageSize = 25;

        if($request->has("page_size")){
            $pageSize = $request->page_size > 0 ? $request->page_size : 25;
        }

        $mangas = $collection->with([
            'authors',
            'genres',
            'publisher',
            'volumes' => function ($query) use ($collectionId) {
                $query->select('manga_volumes.*', DB::raw('exists(select 1 from collection_volume join collection_manga on collection_volume.collection_manga_id = collection_manga.id where collection_volume.manga_volume_id = manga_volumes.id and collection_volume.collection_manga_id = collection_manga.id and collection_manga.collection_id =' . $collectionId . ') as owned'));
            }
            ])->select('*');
        
        if($request->has('ordering')){
            $mangas->orderBy($request->ordering[0] != '-' ? $request->ordering : str_replace('-', '' , $request->ordering), $request->ordering[0] != '-' ? 'asc' : 'desc');
        }

        return $mangas->paginate($pageSize);
    
    }

    /**
     * @OA\Post(
     *     path="/collections",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},     
     *     summary="Store",
     *     @OA\Response(
     *          response=200, 
     *          description="Collection started successfully"
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
    public function store(Request $request)
    {
        if(!$request->user()->hasVerifiedEmail()) return response("You have to verify your email to create a collection", 400);

        $request->user()->collection()->create();
        return response()->json([
            'status' => true,
            'message' => "Collection started succesfully",
            'data' => []
        ]);
    }


    /**
     * @OA\Delete(
     *     path="/collections",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},     
     *     summary="Destroy",
     *     @OA\Response(
     *          response=200, 
     *          description="Collection deleted successfully"
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
    public function destroy(Request $request)
    {
        $request->user->collections()->delete();
        return [
            'status'=> true,
            'message'=> 'Collection deleted successfully'
        ];
    }

    /**
     * @OA\Post(
     *     path="/collections/addManga",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},
     *     summary="Store",
     *     description="Add the volumes from the indicated manga to your collection, if the field volumes is not sended it'll add all the manga volumes to your collection",
     *     @OA\RequestBody(
     *          @OA\JsonContent(    
     *              required={"name", "genre", "author", "publisher_id", "on_going", "volumes"},     
     *              @OA\Property(property="manga", type="string", maxLength=255, example="1"),
     *              @OA\Property(property="volumes", type="integer", example="[1,2]"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Manga added to your collection successfully"
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
     *     @OA\Response(
     *          response=498, 
     *          description="Email not verified"
     *      ),
     * )
     */
    public function addManga(Request $request){

        
        if(!$request->user()->hasVerifiedEmail()) return response("You have to verify your email to create a collection", 498);

        $fields = $request->validate([
            'manga' => 'required',
            'volumes' => ''
        ]);

        $collection = Collection::find($request->user()->collection['id']);

        try{
            $collection_manga = $collection->collectionMangas()->create(['collection_id' => $collection, 'manga_id' => $fields['manga']]);
            if(!isset($fields['volumes'])){
                $volumes = MangaVolume::where('manga_id', $fields['manga'])->pluck('id')->toArray();
                foreach($volumes as $volume){
                    $collection_manga->volumes()->create(['collection_manga_id' => $collection_manga['id'], 'manga_volume_id' => $volume]);
                }
            } else {
                $volumes = MangaVolume::where('manga_id', $fields['manga'])->wherein('number', $fields['volumes'])->pluck('id')->toArray();
                foreach($volumes as $volume){
                    $collection_manga->volumes()->create(['collection_manga_id' => $collection_manga['id'], 'manga_volume_id' => $volume]);
                }
            }
            

        } catch(\Exception $e){
            if($e->getCode() == 23000) return response('You already have this manga on your collection',500);
            else return response($e->getMessage(), 500);
        }

        return [
            'status'=> true,
            'message'=> 'Manga added to your collection successfully'
        ];
  
    }

    public function addVolume(Request $request){

        if(!$request->user()->hasVerifiedEmail()) return response("You have to verify your email to create a collection", 498);

        $fields = $request->validate([
            'manga_id' => 'required|int',
            'volume' => 'required|int'
        ]);

        $collection = Collection::find($request->user()->collection['id']);
        $collection_manga = $collection->collectionMangas()->where('manga_id', $fields['manga_id'])->first();
        try{
            $mangaVolume = MangaVolume::where(['manga_id' => $fields['manga_id'], 'number' => $fields['volume']])->first('id');
            if($mangaVolume){
                CollectionVolume::create(['collection_manga_id' => $collection_manga['id'], 'manga_volume_id' => $mangaVolume['id']]);
            }

        } catch(\Exception $e){
            if($e->getCode() == 23000) return response('You already have this manga on your collection',500);
            else return response($e->getMessage(), 500);
        }

        return [
            'status'=> true,
            'message'=> 'Volume added to your collection successfully'
        ];
    }
}
