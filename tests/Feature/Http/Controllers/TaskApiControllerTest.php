<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('users can show tasks', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $task = Task::factory()->create();

    $response = $this->getJson(`/api/v1/tasks/{$task->id}`);

    $response->assertStatus(200);
});

test('users can update tasks', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $task = Task::factory()->create();
    $payload = Task::factory()->make();

    $response = $this->putJson(`/api/v1/tasks/{$task->id}`, [
        'name' => $payload->name,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'name' => $payload->name,
    ]);
});

test('users can destroy tasks', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $task = Task::factory()->create();
    
    $response = $this->deleteJson(`/api/v1/tasks/{$task->id}`);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
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
