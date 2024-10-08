<?php

use App\Exceptions\UnauthorizedAccessException;
use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\InteractsWithAuthentication;

it('has authors page', function () {
    $response = $this->get('/api/authors');

    $response->assertStatus(200);
});

it('creates an author and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    $authorData = [
        'name' => 'John Doe',
        'user_id' => $user->id
    ];

    try {
        $response = $this->post('/api/authors', $authorData);
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});

it('updates an author and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    $authorData = [
        'name' => 'John Doe',
        'user_id' => $user->id
    ];

    try {
        $author = Author::factory()->create($authorData);
        $updatedAuthor = [
            'id' => $author->id, 
            "name" => "John Doe"
        ];
        $response = $this->patch("/api/authors/{$author->id}", $updatedAuthor);
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});

it('destroys an author and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    try {
        $author = Author::factory()->create();
        $response = $this->delete("/api/authors/{$author->id}");
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});
