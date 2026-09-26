<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_can_manage_users(): void
    {
        $this->actingAs($this->userWithRole('admin'))
            ->get('/admin/users')
            ->assertOk();
    }

    public function test_admin_can_manage_roles_and_permissions(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)->get('/admin/roles')->assertOk();
        $this->actingAs($admin)->get('/admin/permissions')->assertOk();
    }

    public function test_editor_can_manage_users_but_not_roles(): void
    {
        $editor = $this->userWithRole('editor');

        $this->actingAs($editor)->get('/admin/users')->assertOk();
        $this->actingAs($editor)->get('/admin/roles')->assertForbidden();
        $this->actingAs($editor)->get('/admin/permissions')->assertForbidden();
    }

    public function test_basic_user_cannot_access_admin_area(): void
    {
        $user = $this->userWithRole('user');

        $this->actingAs($user)->get('/admin/users')->assertForbidden();
        $this->actingAs($user)->get('/admin/roles')->assertForbidden();
        $this->actingAs($user)->get('/admin/permissions')->assertForbidden();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin/users')->assertRedirect('/login');
        $this->get('/admin/roles')->assertRedirect('/login');
    }

    public function test_admin_role_cannot_be_deleted(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)
            ->delete('/admin/roles/'.Role::findByName('admin')->id)
            ->assertRedirect();

        $this->assertDatabaseHas('roles', ['name' => 'admin']);
    }

    public function test_role_with_assigned_users_cannot_be_deleted(): void
    {
        $admin = $this->userWithRole('admin');
        $editor = Role::findByName('editor');

        $this->actingAs($admin)->delete('/admin/roles/'.$editor->id);

        $this->assertDatabaseHas('roles', ['name' => 'editor']);
    }

    public function test_admin_can_create_a_user_with_roles(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Nuevo',
            'username' => 'nuevo',
            'email' => 'nuevo@dacota.com',
            'password' => 'secreto1234',
            'password_confirmation' => 'secreto1234',
            'roles' => ['editor'],
        ])->assertRedirect();

        $created = User::where('username', 'nuevo')->firstOrFail();

        $this->assertTrue($created->hasRole('editor'));
    }

    public function test_user_cannot_remove_their_own_admin_role(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)->put('/admin/users/'.$admin->id, [
            'name' => $admin->name,
            'username' => $admin->username,
            'email' => $admin->email,
            'roles' => ['user'],
        ]);

        $this->assertTrue($admin->fresh()->hasRole('admin'));
    }

    public function test_user_cannot_delete_their_own_account_from_admin(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)->delete('/admin/users/'.$admin->id);

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_create_a_role_with_permissions(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)->post('/admin/roles', [
            'name' => 'auditor',
            'permissions' => ['users.view'],
        ]);

        $this->assertDatabaseHas('roles', ['name' => 'auditor']);
        $this->assertTrue(Role::findByName('auditor')->hasPermissionTo('users.view'));
    }

    public function test_navigation_hides_admin_links_for_basic_users(): void
    {
        $this->actingAs($this->userWithRole('user'))
            ->get('/dashboard')
            ->assertOk()
            ->assertDontSee(route('admin.roles.index'), false)
            ->assertDontSee(route('admin.users.index'), false);
    }

    public function test_navigation_shows_admin_links_for_admins(): void
    {
        $this->actingAs($this->userWithRole('admin'))
            ->get('/dashboard')
            ->assertOk()
            ->assertSee(route('admin.roles.index'), false)
            ->assertSee(route('admin.users.index'), false)
            ->assertSee(route('admin.permissions.index'), false);
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->syncRoles([$role]);

        return $user;
    }
}
