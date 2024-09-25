<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        return [$collection->with("user")->get()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!$request->user()->hasVerifiedEmail()) return response("You have to verify your email to create a collection", 400);

        $request->user()->collections()->create();
        return [
            'status' => true,
            'message' => "Collection started succesfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Collection $collection)
    {
        $collection->delete();
        return [
            'status'=> true,
            'message'=> 'Collection deleted successfully'
        ];
    }

    public function addManga(Request $request, Collection $collection){

        if(!$request->user()->hasVerifiedEmail()) return response("You have to verify your email to create a collection", 400);

        $fields = $request->validate([
            'manga' => 'required',
        ]);


        try{
            $collection->mangas()->attach($fields['manga']);
        } catch(\Exception $e){
            if($e->getCode() == 23000) return response('You already have this manga on your collection',500);
            else return response($e->getMessage(), 500);
        }

        return [
            'status'=> true,
            'message'=> 'Manga added to your collection successfully'
        ];
  
    }

    public function addVolume(Request $request, Collection $collection){
        $fields = $request->validate([
            'volume' => 'required'
        ]);

        try{
            $collection->volumes()->attach($fields['volume']);
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
