<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_news_listing_filters_by_term_and_category_and_hides_unpublished_articles(): void
    {
        $category = Categoria::factory()->create([
            'nombre' => 'Salud',
            'slug' => 'salud',
        ]);
        $matching = Noticia::factory()->for($category)->create([
            'titulo' => 'Jornada de prevención del dengue',
        ]);
        Noticia::factory()->create([
            'titulo' => 'Aviso de servicios municipales',
        ]);
        Noticia::factory()->unpublished()->create([
            'titulo' => 'Borrador privado del dengue',
        ]);
        Noticia::factory()->create([
            'fecha_publicacion' => today()->addDay(),
            'titulo' => 'Aviso futuro del dengue',
        ]);

        $response = $this->get(route('noticias.index', [
            'buscar' => 'dengue',
            'categoria' => $category->slug,
        ]));

        $response->assertOk();
        $response->assertSee($matching->titulo);
        $response->assertDontSee('Aviso de servicios municipales');
        $response->assertDontSee('Borrador privado del dengue');
        $response->assertDontSee('Aviso futuro del dengue');
    }

    public function test_public_news_listing_paginates_six_articles_per_page(): void
    {
        Noticia::factory()->count(7)->create();

        $response = $this->get(route('noticias.index'));

        $response->assertOk();
        $response->assertViewHas('noticias', fn ($noticias): bool => $noticias->count() === 6 && $noticias->total() === 7);
    }

    public function test_database_seeder_publishes_the_existing_featured_news(): void
    {
        $this->seed();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Cocula reactiva el Sistema de Comando de Incidentes')
            ->assertSee('Sistemas y Salud');

        $this->assertDatabaseHas('noticias', [
            'slug' => 'dengue-comando-incidentes',
        ]);
    }

    public function test_public_news_detail_escapes_content_and_returns_not_found_for_drafts(): void
    {
        $published = Noticia::factory()->create([
            'contenido' => '<script>alert(1)</script>',
        ]);
        $draft = Noticia::factory()->unpublished()->create();
        $scheduled = Noticia::factory()->create([
            'fecha_publicacion' => today()->addDay(),
        ]);

        $response = $this->get(route('noticias.show', $published));

        $response->assertOk();
        $response->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
        $response->assertDontSee('<script>', false);
        $this->get(route('noticias.show', $draft))->assertNotFound();
        $this->get(route('noticias.show', $scheduled))->assertNotFound();
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get(route('admin.noticias.index'))
            ->assertRedirectToRoute('login');
    }

    public function test_authenticated_non_admin_cannot_manage_news(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.noticias.index'))
            ->assertForbidden();
    }

    public function test_admin_can_render_news_creation_form(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('admin.noticias.create'))
            ->assertOk()
            ->assertSee('Crear noticia');
    }

    public function test_admin_can_render_category_creation_form(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('admin.categorias.create'))
            ->assertOk()
            ->assertSee('Crear categoría');
    }

    public function test_admin_can_log_in_and_log_out(): void
    {
        $admin = User::factory()->admin()->create();

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirectToRoute('admin.noticias.index');

        $this->assertAuthenticatedAs($admin);

        $this->post(route('logout'))
            ->assertRedirectToRoute('home');

        $this->assertGuest();
    }

    public function test_non_admin_credentials_cannot_start_an_admin_session(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_create_news_with_unique_slug_and_cover_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $category = Categoria::factory()->create();
        Noticia::factory()->for($category)->create([
            'titulo' => 'Nueva obra municipal',
            'slug' => 'nueva-obra-municipal',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.noticias.store'), [
                'titulo' => 'Nueva obra municipal',
                'categoria_id' => $category->id,
                'extracto' => 'Resumen de la obra.',
                'contenido' => 'Información completa de la obra.',
                'imagen_portada' => UploadedFile::fake()->image('portada.jpg'),
                'fecha_publicacion' => today()->toDateString(),
                'publicado' => '1',
            ])
            ->assertRedirectToRoute('admin.noticias.index');

        $this->assertDatabaseHas('noticias', [
            'titulo' => 'Nueva obra municipal',
            'slug' => 'nueva-obra-municipal-2',
            'categoria_id' => $category->id,
            'user_id' => $admin->id,
            'publicado' => true,
        ]);

        $noticia = Noticia::query()->where('slug', 'nueva-obra-municipal-2')->firstOrFail();
        Storage::disk('public')->assertExists($noticia->imagen_portada);
    }

    public function test_admin_news_validation_rejects_missing_required_fields(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.noticias.store'), [])
            ->assertSessionHasErrors(['titulo', 'categoria_id', 'extracto', 'contenido', 'fecha_publicacion']);

        $this->assertDatabaseCount('noticias', 0);
    }

    public function test_admin_news_validation_rejects_unsupported_cover_images(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.noticias.store'), [
                'titulo' => 'Noticia con archivo inválido',
                'categoria_id' => Categoria::factory()->create()->id,
                'extracto' => 'Resumen.',
                'contenido' => 'Contenido.',
                'imagen_portada' => UploadedFile::fake()->create('portada.svg', 100, 'image/svg+xml'),
                'fecha_publicacion' => today()->toDateString(),
            ])
            ->assertSessionHasErrors('imagen_portada');

        $this->assertDatabaseCount('noticias', 0);
    }

    public function test_admin_can_update_and_delete_news(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $noticia = Noticia::factory()->for($admin, 'autor')->create([
            'titulo' => 'Aviso anterior',
            'slug' => 'aviso-anterior',
            'imagen_portada' => UploadedFile::fake()->image('anterior.jpg')->store('noticias', 'public'),
        ]);
        $category = Categoria::factory()->create();

        $this->actingAs($admin)
            ->put(route('admin.noticias.update', $noticia), [
                'titulo' => 'Aviso actualizado',
                'categoria_id' => $category->id,
                'extracto' => 'Nuevo resumen.',
                'contenido' => 'Nuevo contenido.',
                'fecha_publicacion' => today()->toDateString(),
            ])
            ->assertRedirectToRoute('admin.noticias.index');

        $this->assertDatabaseHas('noticias', [
            'id' => $noticia->id,
            'slug' => 'aviso-actualizado',
            'publicado' => false,
        ]);

        $this->delete(route('admin.noticias.destroy', $noticia->fresh()))
            ->assertRedirectToRoute('admin.noticias.index');

        $this->assertDatabaseMissing('noticias', ['id' => $noticia->id]);
    }

    public function test_admin_can_manage_categories_and_deleting_one_removes_its_news(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.categorias.store'), [
                'nombre' => 'Protección Civil',
                'descripcion' => 'Avisos y acciones de prevención.',
            ])
            ->assertRedirectToRoute('admin.categorias.index');

        $category = Categoria::query()->where('slug', 'proteccion-civil')->firstOrFail();
        $noticia = Noticia::factory()->for($category)->create();

        $this->put(route('admin.categorias.update', $category), [
            'nombre' => 'Protección Ciudadana',
            'descripcion' => 'Actualización de categoría.',
        ])->assertRedirectToRoute('admin.categorias.index');

        $this->assertDatabaseHas('categorias', [
            'id' => $category->id,
            'slug' => 'proteccion-ciudadana',
        ]);

        $this->delete(route('admin.categorias.destroy', $category->fresh()))
            ->assertRedirectToRoute('admin.categorias.index');

        $this->assertDatabaseMissing('noticias', ['id' => $noticia->id]);
    }

    public function test_news_admin_command_creates_a_hashed_admin_account(): void
    {
        $this->artisan('news:create-admin')
            ->expectsQuestion('Nombre del administrador', 'María Administradora')
            ->expectsQuestion('Correo electrónico', 'admin@cocula.gob.mx')
            ->expectsQuestion('Contraseña (mínimo 12 caracteres)', 'UnaClaveSegura123')
            ->expectsQuestion('Confirma la contraseña', 'UnaClaveSegura123')
            ->assertExitCode(0);

        $admin = User::query()->where('email', 'admin@cocula.gob.mx')->firstOrFail();

        $this->assertTrue($admin->isAdmin());
        $this->assertTrue(Hash::check('UnaClaveSegura123', $admin->password));
    }

    public function test_news_admin_command_rejects_a_short_password(): void
    {
        $this->artisan('news:create-admin')
            ->expectsQuestion('Nombre del administrador', 'María Administradora')
            ->expectsQuestion('Correo electrónico', 'admin@cocula.gob.mx')
            ->expectsQuestion('Contraseña (mínimo 12 caracteres)', 'short')
            ->expectsQuestion('Confirma la contraseña', 'short')
            ->assertExitCode(1);

        $this->assertDatabaseMissing('users', [
            'email' => 'admin@cocula.gob.mx',
        ]);
    }
}
