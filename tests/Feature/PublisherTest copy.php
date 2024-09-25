<?php

use App\Exceptions\UnauthorizedAccessException;
use App\Models\Publisher;
use App\Models\User;

it('has publishers page', function () {
    $response = $this->get('/api/publishers');

    $response->assertStatus(200);
});

it('creates an publisher and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    $publisherData = [
        'name' => 'editora ficticia',
        'user_id' => $user->id
    ];


    try {
        $response = $this->post('/api/publishers', $publisherData);
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});

it('updates an publisher and returns 200 or throws UnauthorizedAccessException', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user);

    $publisherData = [
        'name' => 'editora ficticia',
        'user_id' => $user->id
    ];

    try {
        $publisher = Publisher::factory()->create($publisherData);
        $updatedPublisher = [
            'id' => $publisher->id, 
            "name" => "genero ficticia 2"
        ];
        $response = $this->patch("/api/publishers/{$publisher->id}", $updatedPublisher);
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});

it('destroys an publisher and returns 200 or throws UnauthorizedAccessException', function () {
    // Create a user with necessary permissions
    $user = User::factory()->create(['is_admin' => true]);

    // Acting as the created user
    $this->actingAs($user);

    // Try to create the publisher and catch any UnauthorizedAccessException
    try {
        $publisher = Publisher::factory()->create();
        $response = $this->delete("/api/publishers/{$publisher->id}");
        $response->assertStatus(200);
    } catch (UnauthorizedAccessException $e) {
        expect($e)->toBeInstanceOf(UnauthorizedAccessException::class);
    }
});
