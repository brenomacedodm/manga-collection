<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Author;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    /** @test */
    public function can_create_a_user()
    {
        $user = User::create([
            "name"=> "John Doe",
            "email"=> "JohnDoe@teste.com",
            "password" => bcrypt("123456"),
            "is_admin" => true
        ]);


        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe',
        ]);
    }

    /** @test */
    public function can_update_a_user()
    {
        $author = Author::factory()->create();

        $author->update(['name' => 'Jane Doe']);

        $this->assertEquals('Jane Doe', $author->fresh()->name);
    }

    /** @test */
    public function can_delete_an_author()
    {
        $author = Author::factory()->create();

        $author->delete();

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
