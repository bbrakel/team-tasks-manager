<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('users can index tasks for projects', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory()
        ->has(Task::factory(5))->create();

    $response = $this->getJson(`/api/v1/projects/{$project->id}/tasks`);

    $response->assertStatus(200);
});

test('users can index tasks for projects with filter', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory()
        ->has(Task::factory(5))->create();

    $response = $this->getJson(`/api/v1/projects/{$project->id}/tasks`, [
        'name' => $project->tasks->first()->name,
    ]);

    $response->assertStatus(200);
});

test('users can store tasks for projects', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory()->create();

    $payload = Task::factory()->make();

    $response = $this->postJson(`/api/v1/projects/{$project->id}/tasks`, [
        'name' => $payload->name,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('tasks', [
        'name' => $payload->name,
    ]);
});
