<?php

use App\Http\Controllers\Auth\VerifyEmailController;
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
Route::post("/changePassword", [UsersController::class, "changePassword"])->middleware("auth:sanctum");
Route::post("/setAdmin/{user_id}", [UsersController::class, "setAdmin"])->middleware("auth:sanctum");

Route::post("/mangas/authors/{manga}", [MangasController::class, "updateAuthors"])->middleware("auth:sanctum");
Route::post("/mangas/genres/{manga}", [MangasController::class, "updateGenres"])->middleware("auth:sanctum");

Route::post("/collections/addManga", [CollectionsController::class, "addManga"])->middleware("auth:sanctum");
Route::post("/collections/addVolume", [CollectionsController::class, "addVolume"])->middleware("auth:sanctum");

Route::post('email/verify/send', [VerifyEmailController::class,'sendMail'])->middleware("auth:sanctum");
Route::post('email/verify', [VerifyEmailController::class,'verify'])->middleware("auth:sanctum")->name("verify-email");
Route::get('email/verify', [VerifyEmailController::class,'verify'])->middleware("auth:sanctum")->name("verify-email");