<?php

use App\Exceptions\UnauthorizedAccessException;
use App\Models\Genre;
use App\Models\User;

it('has genres page', function () {
    $response = $this->get('/api/genres');

    $response->assertStatus(200);
});

it('creates an genre and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    $genreData = [
        'name' => 'genero ficticio',
        'user_id' => $user->id
    ];


    try {
        $response = $this->post('/api/genres', $genreData);
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});

it('updates an genre and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    $genreData = [
        'name' => 'genero ficticio',
        'user_id' => $user->id
    ];

    try {
        $genre = Genre::factory()->create($genreData);
        $updatedGenre = [
            'id' => $genre->id, 
            "name" => "genero ficticio 2"
        ];
        $response = $this->patch("/api/genres/{$genre->id}", $updatedGenre);
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});

it('destroys an genre and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    try {
        $genre = Genre::factory()->create();
        $response = $this->delete("/api/genres/{$genre->id}");
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});
