<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('users can index users', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->getJson('/api/v1/users');

    $response->assertStatus(200);
});

test('users can show users', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $user = User::factory()->create();

    $response = $this->getJson(`/api/v1/users/{$user->id}`);

    $response->assertStatus(200);
});

test('users can update users', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $user = User::factory()->create();
    $payload = User::factory()->make();

    $response = $this->putJson(`/api/v1/users/{$user->id}`, [
        'name' => $payload->name,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $payload->name,
    ]);
});

test('users can destroy users', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $user = User::factory()->create();

    $response = $this->deleteJson(`/api/v1/users/{$user->id}`);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

test('guests cannot index users', function (): void {
    $response = $this->getJson('/api/v1/users');
    $response->assertStatus(401);
});

test('guests cannot show users', function (): void {
    $response = $this->getJson('/api/v1/users/0');
    $response->assertStatus(401);
});

test('guests cannot update users', function (): void {
    $response = $this->putJson('/api/v1/users/0');
    $response->assertStatus(401);
});

test('guests cannot destroy users', function (): void {
    $response = $this->deleteJson('/api/v1/users/0');
    $response->assertStatus(401);
});
