<?php

namespace Tests\Feature;

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
        $this->get('/contract')
            ->assertStatus(200)
            ->assertSee('Contracts');
    }
}
