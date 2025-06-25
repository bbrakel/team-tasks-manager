<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('tasks have attributes', function (): void {
    $user = Team::factory()->create();

    expect($user)
        ->toHaveProperties([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);
});
