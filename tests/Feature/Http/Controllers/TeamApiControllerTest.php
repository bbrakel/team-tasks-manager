<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('admins can index teams', function (): void {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
    
    $response = $this->getJson('/api/v1/teams');

    $response->assertStatus(200);
});

test('admins can show teams', function (): void {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
    
    $team = Team::factory()->create();

    $response = $this->getJson(`/api/v1/teams/{$team->id}`);

    $response->assertStatus(200);
});

test('admins can store teams', function (): void {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
    
    $payload = Team::factory()->make();

    $response = $this->postJson('/api/v1/teams', [
        'name' => $payload->name,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('teams', [
        'name' => $payload->name,
    ]);
});

test('admins can update teams', function (): void {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
    
    $team = Team::factory()->create();
    $payload = Team::factory()->make();

    $response = $this->putJson(`/api/v1/teams/{$team->id}`, [
        'name' => $payload->name,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('teams', [
        'id' => $team->id,
        'name' => $payload->name,
    ]);
});

test('admins can destroy teams', function (): void {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
    
    $team = Team::factory()->create();
    
    $response = $this->deleteJson(`/api/v1/teams/{$team->id}`);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('teams', [
        'id' => $team->id,
    ]);
});

test('users cannot index teams', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->getJson('/api/v1/teams');
    $response->assertStatus(401);
});

test('users cannot show teams', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->getJson('/api/v1/teams/0');
    $response->assertStatus(401);
});

test('users cannot store teams', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/v1/teams');
    $response->assertStatus(401);
});

test('users cannot update teams', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->putJson('/api/v1/teams/0');
    $response->assertStatus(401);
});

test('users cannot destroy teams', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->deleteJson('/api/v1/teams/0');
    $response->assertStatus(401);
});

test('guests cannot index teams', function (): void {
    $response = $this->getJson('/api/v1/teams');
    $response->assertStatus(401);
});

test('guests cannot show teams', function (): void {
    $response = $this->getJson('/api/v1/teams/0');
    $response->assertStatus(401);
});

test('guests cannot store teams', function (): void {
    $response = $this->postJson('/api/v1/teams');
    $response->assertStatus(401);
});

test('guests cannot update teams', function (): void {
    $response = $this->putJson('/api/v1/teams/0');
    $response->assertStatus(401);
});

test('guests cannot destroy teams', function (): void {
    $response = $this->deleteJson('/api/v1/teams/0');
    $response->assertStatus(401);
});
