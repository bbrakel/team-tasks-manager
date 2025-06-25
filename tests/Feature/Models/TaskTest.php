<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('tasks have attributes', function (): void {
    $user = User::factory()->create();

    expect($user)
        ->toHaveProperties([
            'id',
            'title',
            'description',
            'status',
            'due_date',
            'project_id',
            'created_at',
            'updated_at',
        ]);
});

test('tasks belongs to projects', function (): void {
    $user = Task::factory()
        ->for(Project::factory())
        ->create();

    $project = $user->project;

    expect($project)
        ->toBeInstanceOf(Collection::class)
        ->first()->toBeInstanceOf(Project::class);
});
