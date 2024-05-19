<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Loadtreatments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LoadtreatmentsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Loadtreatments::class)
            ->assertStatus(200);
    }
}
