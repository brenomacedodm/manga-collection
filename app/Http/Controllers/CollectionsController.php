<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Gate;


class CollectionsController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except:['index', 'show'])
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        return [$collection];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('defaultPolicy', $request->user());
        
        $fields = $request->validate([
            'manga_volume_id'=> 'required',
        ]);

        $request->user()->collections()->create($fields);
        return [
            'status' => true,
            'message' => "Volume added to your collection successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Collection $collection)
    {
        Gate::authorize('defaultPolicy', $request->user());

        $collection->delete();
        return [
            'status'=> true,
            'message'=> 'Volume removed from your collection successfully'
        ];
    }
}
