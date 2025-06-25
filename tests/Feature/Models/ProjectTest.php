<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('projects have attributes', function (): void {
    $user = User::factory()->create();

    expect($user)
        ->toHaveProperties([
            'id',
            'name',
            'description',
            'team_id',
            'created_at',
            'updated_at',
        ]);
});

it('projects belongs to teams', function (): void {
    $user = Project::factory()
        ->for(Team::factory())
        ->create();

    $team = $user->team;

    expect($team)
        ->toBeInstanceOf(Collection::class)
        ->first()->toBeInstanceOf(Team::class);
});
