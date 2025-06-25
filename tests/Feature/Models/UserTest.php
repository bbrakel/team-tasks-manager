<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Collection;

uses(LazilyRefreshDatabase::class);

test('users have attributes', function (): void {
    $user = User::factory()->create();

    expect($user)
        ->toHaveProperties([
            'id',
            'name',
            'email',
            'password',
            'team_id',
            'created_at',
            'updated_at',
        ]);
});

test('users belongs to teams', function (): void {
    $user = User::factory()
        ->for(Team::factory())
        ->create();

    $team = $user->team;

    expect($team)
        ->toBeInstanceOf(Collection::class)
        ->first()->toBeInstanceOf(Team::class);
});
