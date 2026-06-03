<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
        ]);
    }

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
        
        // Define gates for the test
        Gate::define('posts_create', function ($user) {
            return $user->hasPermission('posts_create');
        });

        $this->actingAs($user);

        // Status 'pending' is allowed in validation, but 'posts_create' permission is still needed in controller
        $response = $this->post('/posts', [
            'title' => 'New Staff Post',
            'content' => 'Some content',
            'status' => 'pending', 
        ]);

        $response->assertStatus(403);
    }
}
