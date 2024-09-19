<?php

namespace App\Http\Controllers;

use App\Models\mangaVolumes;
use App\Http\Requests\StoremangaVolumesRequest;
use App\Http\Requests\UpdatemangaVolumesRequest;

class MangaVolumesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //isAdmin || isVerified
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoremangaVolumesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(mangaVolumes $mangaVolumes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemangaVolumesRequest $request, mangaVolumes $mangaVolumes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mangaVolumes $mangaVolumes)
    {
        //
    }
}
