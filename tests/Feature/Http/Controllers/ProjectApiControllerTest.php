<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('users can index projects', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory([
        'name' => 'Test Project',
    ])->has($user)->create();

    Project::factory(4)->create();

    $response = $this->getJson('/api/v1/projects');

    $response->assertStatus(200);
    $response->assertJson([
        ['name' => $project->name],
    ]);
});

test('users can index projects with filters', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory([
        'name' => 'Test Project',
    ])->has($user)->create();

    Project::factory(4)->create();

    $response = $this->getJson('/api/v1/projects', [
        'name' => $project->name,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        ['name' => $project->name],
    ]);
});

test('users can show projects', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory()->create();

    $response = $this->getJson(`/api/v1/projects/{$project->id}`);

    $response->assertStatus(200);
});

test('users can store projects', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $payload = Project::factory()->make();

    $response = $this->postJson('/api/v1/projects', [
        'name' => $payload->name,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('projects', [
        'name' => $payload->name,
    ]);
});

test('users can update projects', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory()->create();
    $payload = Project::factory()->make();

    $response = $this->putJson(`/api/v1/projects/{$project->id}`, [
        'name' => $payload->name,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'name' => $payload->name,
    ]);
});

test('users can destroy projects', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory()->create();

    $response = $this->deleteJson(`/api/v1/projects/{$project->id}`);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});

test('guests cannot index projects', function (): void {
    $response = $this->getJson('/api/v1/projects');
    $response->assertStatus(401);
});

test('guests cannot show projects', function (): void {
    $response = $this->getJson('/api/v1/projects/0');
    $response->assertStatus(401);
});

test('guests cannot store projects', function (): void {
    $response = $this->postJson('/api/v1/projects');
    $response->assertStatus(401);
});

test('guests cannot update projects', function (): void {
    $response = $this->putJson('/api/v1/projects/0');
    $response->assertStatus(401);
});

test('guests cannot destroy projects', function (): void {
    $response = $this->deleteJson('/api/v1/projects/0');
    $response->assertStatus(401);
});
