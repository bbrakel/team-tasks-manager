<?php

namespace Tests\Feature\Http\Controllers;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('guests can register', function (): void {
    $user = User::factory()->make();
    $team = Team::factory()->create(['code' => 'test']);

    $response = $this->post('/api/auth/register', [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'password',
        'password_confirmation' => 'password',
        'team_code' => 'test',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => $user->email,
        'team_id' => $team->id,
    ]);
});

test('users can login', function (): void {
    $user = User::factory()->create([
        'name' => 'Test User',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
});

