<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{

    /** @test */
    public function can_create_an_author()
    {
        $author = Author::create([
            'name' => 'John Doe',
            'picture' => '',
        ]);

        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'name' => 'John Doe',
            'picture' => '',
        ]);
    }

    /** @test */
    public function can_update_an_author()
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
