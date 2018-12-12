<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractTest extends TestCase
{
    /**
     * @test
     */
    function load_all_contract()
    {
        $this->get('/contract')
        ->assertStatus(200)
        ->assertSee('index contract');
    }
}
