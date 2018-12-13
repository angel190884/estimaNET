<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    function test_welcome_status_200()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Estimanet');
    }

    /**
     * @test
     */
    function dar_bienvenida_a_usuario_autenticado()
    {
        $user = factory(User::class)->create([
            'name' => 'Angel Daniel Peregrino Juarez',
            'email' => 'angel190884@gmail.com'
        ]);

        $this->actingAs($user)
            ->get('/')
            ->assertSee('Home');
    }

    /**
     * @test
     */
    function dar_bienvenida_a_usuario_no_autenticado()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Login')
            ->assertSee('Register');
    }
}
