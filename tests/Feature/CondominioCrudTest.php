<?php

namespace Tests\Feature;

use App\Models\Condominio;
use App\Models\TipoCondominio;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CondominioCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_can_manage_condominios_and_tipos(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)->get('/admin/condominios')->assertOk();
        $this->actingAs($admin)->get('/admin/tipo-condominios')->assertOk();
    }

    public function test_editor_can_manage_condominios_and_tipos(): void
    {
        $editor = $this->userWithRole('editor');

        $this->actingAs($editor)->get('/admin/condominios')->assertOk();
        $this->actingAs($editor)->get('/admin/tipo-condominios')->assertOk();
    }

    public function test_basic_user_cannot_access_condominios(): void
    {
        $user = $this->userWithRole('user');

        $this->actingAs($user)->get('/admin/condominios')->assertForbidden();
        $this->actingAs($user)->get('/admin/tipo-condominios')->assertForbidden();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin/condominios')->assertRedirect('/login');
        $this->get('/admin/tipo-condominios')->assertRedirect('/login');
    }

    public function test_created_condominio_registers_the_authenticated_user_as_owner(): void
    {
        $editor = $this->userWithRole('editor');
        $tipo = TipoCondominio::firstOrFail();

        $this->actingAs($editor)->post('/admin/condominios', [
            'nombre' => 'Las Palmas',
            'tipo_condominio_id' => $tipo->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('condominios', [
            'nombre' => 'Las Palmas',
            'tipo_condominio_id' => $tipo->id,
            'user_id' => $editor->id,
        ]);
    }

    public function test_condominio_index_renders_the_status_message_after_creating(): void
    {
        $editor = $this->userWithRole('editor');

        $this->actingAs($editor)
            ->post('/admin/condominios', [
                'nombre' => 'Las Palmas',
                'tipo_condominio_id' => TipoCondominio::firstOrFail()->id,
            ])
            ->assertRedirect();

        $this->actingAs($editor)
            ->get('/admin/condominios')
            ->assertOk()
            ->assertSee('Condominio creado correctamente.');
    }

    public function test_tipo_index_renders_the_error_message_when_delete_is_blocked(): void
    {
        $editor = $this->userWithRole('editor');
        $tipo = TipoCondominio::factory()->create();
        Condominio::factory()->create(['tipo_condominio_id' => $tipo->id]);

        $this->actingAs($editor)
            ->delete('/admin/tipo-condominios/'.$tipo->id)
            ->assertRedirect();

        $this->actingAs($editor)
            ->get('/admin/tipo-condominios')
            ->assertOk()
            ->assertSee('Reasígnalos antes de eliminarlo.');
    }

    public function test_condominio_creation_rejects_an_empty_payload(): void
    {
        $this->actingAs($this->userWithRole('admin'))
            ->post('/admin/condominios', [])
            ->assertSessionHasErrors(['nombre', 'tipo_condominio_id']);

        $this->assertDatabaseCount('condominios', 0);
    }

    public function test_condominio_creation_rejects_an_unknown_tipo(): void
    {
        $this->actingAs($this->userWithRole('admin'))
            ->post('/admin/condominios', [
                'nombre' => 'Sin tipo',
                'tipo_condominio_id' => 9999,
            ])
            ->assertSessionHasErrors('tipo_condominio_id');

        $this->assertDatabaseCount('condominios', 0);
    }

    public function test_condominio_can_be_updated(): void
    {
        $condominio = Condominio::factory()->create(['nombre' => 'Nombre anterior']);
        $tipo = TipoCondominio::where('id', '!=', $condominio->tipo_condominio_id)->firstOrFail();

        $this->actingAs($this->userWithRole('admin'))->put('/admin/condominios/'.$condominio->id, [
            'nombre' => 'Nombre nuevo',
            'tipo_condominio_id' => $tipo->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('condominios', [
            'id' => $condominio->id,
            'nombre' => 'Nombre nuevo',
            'tipo_condominio_id' => $tipo->id,
        ]);
    }

    public function test_condominio_update_keeps_the_original_owner(): void
    {
        $condominio = Condominio::factory()->create();

        $this->actingAs($this->userWithRole('admin'))->put('/admin/condominios/'.$condominio->id, [
            'nombre' => 'Otro nombre',
            'tipo_condominio_id' => $condominio->tipo_condominio_id,
        ])->assertRedirect();

        $this->assertDatabaseHas('condominios', [
            'id' => $condominio->id,
            'user_id' => $condominio->user_id,
        ]);
    }

    public function test_condominio_can_be_deleted(): void
    {
        $condominio = Condominio::factory()->create();

        $this->actingAs($this->userWithRole('admin'))
            ->delete('/admin/condominios/'.$condominio->id)
            ->assertRedirect();

        $this->assertDatabaseMissing('condominios', ['id' => $condominio->id]);
    }

    public function test_search_filters_condominios_by_name(): void
    {
        $coincide = Condominio::factory()->create(['nombre' => 'Residencial El Faro']);
        Condominio::factory()->create(['nombre' => 'Urbanizacion La Costa']);

        $this->actingAs($this->userWithRole('admin'))
            ->get('/admin/condominios?search=Faro')
            ->assertOk()
            ->assertSee($coincide->nombre)
            ->assertDontSee('Urbanizacion La Costa');
    }

    public function test_search_filters_condominios_by_tipo_name(): void
    {
        $tipo = TipoCondominio::factory()->create(['nombre' => 'Torre premium']);
        $coincide = Condominio::factory()->create(['nombre' => 'Edificio Centro', 'tipo_condominio_id' => $tipo->id]);
        $otro = Condominio::factory()->create(['nombre' => 'Casa Reciente']);

        $this->actingAs($this->userWithRole('admin'))
            ->get('/admin/condominios?search=Torre+premium')
            ->assertOk()
            ->assertSee($coincide->nombre)
            ->assertDontSee($otro->nombre);
    }

    public function test_condominios_can_be_filtered_by_tipo(): void
    {
        $tipo = TipoCondominio::factory()->create();
        $coincide = Condominio::factory()->create(['nombre' => 'Edificio Filtrado', 'tipo_condominio_id' => $tipo->id]);
        $otro = Condominio::factory()->create(['nombre' => 'Edificio Excluido']);

        $this->actingAs($this->userWithRole('admin'))
            ->get('/admin/condominios?tipo_condominio_id='.$tipo->id)
            ->assertOk()
            ->assertSee($coincide->nombre)
            ->assertDontSee($otro->nombre);
    }

    public function test_created_tipo_is_persisted(): void
    {
        $this->actingAs($this->userWithRole('admin'))
            ->post('/admin/tipo-condominios', ['nombre' => 'Complejo de casas'])
            ->assertRedirect();

        $this->assertDatabaseHas('tipo_condominios', ['nombre' => 'Complejo de casas']);
    }

    public function test_tipo_creation_rejects_a_duplicated_name(): void
    {
        $tipo = TipoCondominio::firstOrFail();

        $this->actingAs($this->userWithRole('admin'))
            ->post('/admin/tipo-condominios', ['nombre' => $tipo->nombre])
            ->assertSessionHasErrors('nombre');

        $this->assertDatabaseCount('tipo_condominios', TipoCondominio::count());
    }

    public function test_tipo_can_be_updated(): void
    {
        $tipo = TipoCondominio::factory()->create(['nombre' => 'Nombre anterior']);

        $this->actingAs($this->userWithRole('admin'))->put('/admin/tipo-condominios/'.$tipo->id, [
            'nombre' => 'Nombre actualizado',
        ])->assertRedirect();

        $this->assertDatabaseHas('tipo_condominios', [
            'id' => $tipo->id,
            'nombre' => 'Nombre actualizado',
        ]);
    }

    public function test_tipo_without_condominios_can_be_deleted(): void
    {
        $tipo = TipoCondominio::factory()->create();

        $this->actingAs($this->userWithRole('admin'))
            ->delete('/admin/tipo-condominios/'.$tipo->id)
            ->assertRedirect();

        $this->assertDatabaseMissing('tipo_condominios', ['id' => $tipo->id]);
    }

    public function test_tipo_with_condominios_cannot_be_deleted(): void
    {
        $tipo = TipoCondominio::factory()->create();
        Condominio::factory()->create(['tipo_condominio_id' => $tipo->id]);

        $this->actingAs($this->userWithRole('admin'))
            ->delete('/admin/tipo-condominios/'.$tipo->id)
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('tipo_condominios', ['id' => $tipo->id]);
    }

    public function test_search_filters_tipos_by_name(): void
    {
        $coincide = TipoCondominio::factory()->create(['nombre' => 'Residencial premium']);
        $otro = TipoCondominio::factory()->create();

        $this->actingAs($this->userWithRole('admin'))
            ->get('/admin/tipo-condominios?search=premium')
            ->assertOk()
            ->assertSee($coincide->nombre)
            ->assertDontSee($otro->nombre);
    }

    public function test_sidebar_shows_condominio_links_for_admins(): void
    {
        $this->actingAs($this->userWithRole('admin'))
            ->get('/dashboard')
            ->assertOk()
            ->assertSee(route('admin.condominios.index'), false)
            ->assertSee(route('admin.tipo-condominios.index'), false);
    }

    public function test_sidebar_shows_condominio_links_for_editors(): void
    {
        $this->actingAs($this->userWithRole('editor'))
            ->get('/dashboard')
            ->assertOk()
            ->assertSee(route('admin.condominios.index'), false)
            ->assertSee(route('admin.tipo-condominios.index'), false);
    }

    public function test_sidebar_hides_condominio_links_for_basic_users(): void
    {
        $this->actingAs($this->userWithRole('user'))
            ->get('/dashboard')
            ->assertOk()
            ->assertDontSee(route('admin.condominios.index'), false)
            ->assertDontSee(route('admin.tipo-condominios.index'), false);
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->syncRoles([$role]);

        return $user;
    }
}
