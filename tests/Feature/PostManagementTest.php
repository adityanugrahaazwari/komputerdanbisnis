<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_see_published_posts()
    {
        $post = Post::factory()->create(['status' => 'published', 'title' => 'Sample News']);

        $response = $this->get('/berita');

        $response->assertStatus(200);
        $response->assertSee('Sample News');
    }

    public function test_staff_cannot_publish_posts_without_permission()
    {
        $user = User::factory()->create();
        // Assume default user has no posts_publish permission
        
        $this->actingAs($user);

        $response = $this->post('/posts', [
            'title' => 'New Staff Post',
            'content' => 'Some content',
            'status' => 'published', // Try to publish
        ]);

        $response->assertStatus(403);
    }
}
