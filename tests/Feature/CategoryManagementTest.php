<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
        ]);

        // Setup Admin with permissions
        $this->admin = User::factory()->create();
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        
        $permissions = [
            'categories_view',
            'categories_create',
            'categories_edit',
            'categories_delete'
        ];

        foreach ($permissions as $slug) {
            $permission = Permission::create(['name' => $slug, 'slug' => $slug]);
            $adminRole->permissions()->attach($permission);
            
            // Define gate manually for the test
            Gate::define($slug, function ($user) use ($slug) {
                return $user->hasPermission($slug);
            });
        }

        $this->admin->roles()->attach($adminRole);
    }

    public function test_admin_can_view_categories_index()
    {
        $this->actingAs($this->admin);
        
        Category::factory()->create(['name' => 'Tech']);
        
        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Tech');
    }

    public function test_admin_can_create_category()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('categories.store'), [
            'name' => 'Business',
            'description' => 'Business news'
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Business']);
    }

    public function test_admin_can_update_category()
    {
        $this->actingAs($this->admin);
        $category = Category::factory()->create(['name' => 'Old Name']);

        $response = $this->put(route('categories.update', $category), [
            'name' => 'New Name',
            'description' => 'Updated description'
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'New Name']);
    }

    public function test_admin_can_delete_category()
    {
        $this->actingAs($this->admin);
        $category = Category::factory()->create(['name' => 'To Be Deleted']);

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_unauthorized_user_cannot_access_categories()
    {
        $user = User::factory()->create(); // No permissions
        $this->actingAs($user);

        $response = $this->get(route('categories.index'));
        $response->assertStatus(403);
    }
}
