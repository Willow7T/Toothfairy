<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CardHome;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CardHomeTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CardHome::class)
            ->assertStatus(200);
    }
}
