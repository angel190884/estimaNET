<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContractTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    function load_all_contracts()
    {
        $user = new User([
            'name' => 'Angel Peregrino Juarez',
            'email' => 'angel190884@gmail.com',
        ]);
        $this->actingAs($user)
            ->get('/contract')
            ->assertStatus(200)
            ->assertSee('Contracts');
    }
}
