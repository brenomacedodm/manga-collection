<?php

use App\Http\Controllers\PublishersController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\MangasController;
use App\Http\Controllers\MangaVolumesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckToken;

Route::apiResource("publishers", PublishersController::class)->middleware(CheckToken::class);
Route::apiResource("authors", AuthorsController::class)->middleware(CheckToken::class);
Route::apiResource("collections", CollectionsController::class)->middleware(CheckToken::class);
Route::apiResource("genres", GenresController::class)->middleware(CheckToken::class);
Route::apiResource("mangas", MangasController::class)->middleware(CheckToken::class);
Route::apiResource("mangaVolumes", MangaVolumesController::class)->middleware(CheckToken::class);
// Route::apiResource("users", UsersController::class);

Route::post("/register", [UsersController::class, "register"]);
Route::post("/login", [UsersController::class, "login"]);
Route::post("/logout", [UsersController::class, "logout"])->middleware("auth:sanctum");

Route::post("/mangas/authors/{manga}", [MangasController::class, "updateAuthors"])->middleware("auth:sanctum");
Route::post("/mangas/genres/{manga}", [MangasController::class, "updateGenres"])->middleware("auth:sanctum");

Route::post("/collections/addManga", [CollectionsController::class, "addManga"])->middleware("auth:sanctum");
Route::post("/collections/addVolume", [CollectionsController::class, "addVolume"])->middleware("auth:sanctum");
