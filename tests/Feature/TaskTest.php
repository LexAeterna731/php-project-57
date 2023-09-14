<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $creator;
    private Task $task;
    private array $data;
    private TaskStatus $status;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->creator = User::factory()->create();
        $this->task = Task::factory()->create([
            'created_by_id' => $this->creator->id,
        ]);
        $this->status = TaskStatus::factory()->create();
        $this->data = [
            'name' => 'testTask',
            'description' => 'test description',
            'status_id' => $this->status->id,
            'created_by_id' => $this->creator->id,
            'assigned_to_id' => $this->user->id,
        ];
    }

    public function testTasksScreenCanBeRendered(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
    }

    public function testTaskScreenCanBeRendered(): void
    {
        $response = $this->get(route('tasks.show', $this->task));

        $response->assertStatus(200);
    }

    public function testTaskCreateScreenCanBeRenderedForUser(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('tasks.create'));

        $response->assertStatus(200);
    }

    public function testTaskCreateScreenCantBeRenderedForGuest(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertStatus(403);
    }

    public function testUserCanCreateTask(): void
    {
        $response = $this->actingAs($this->creator)
            ->withSession(['banned' => false])
            ->post(route('tasks.store', $this->data));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $this->data);
    }

    public function testGuestCantCreateTask(): void
    {
        $response = $this->post(route('tasks.store', $this->data));

        $response->assertStatus(403);
        $this->assertDatabaseMissing('tasks', $this->data);
    }

    public function testTaskEditScreenCanBeRenderedForUser(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('tasks.edit', $this->task));

        $response->assertStatus(200);
    }

    public function testTaskEditScreenCantBeRenderedForGuest(): void
    {
        $response = $this->get(route('tasks.edit', $this->task));

        $response->assertStatus(403);
    }

    public function testUserCanEditTask(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->put(route('tasks.update', $this->task), $this->data);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $this->data);
    }

    public function testGuestCantEditTask(): void
    {
        $response = $this->put(route('tasks.update', $this->task), $this->data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('tasks', $this->data);
    }

    public function testGuestCantDeleteTask(): void
    {
        $response = $this->delete(route('tasks.destroy', $this->task));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', $this->task->only(['name']));
    }

    public function testRandomUserCantDeleteTask(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('tasks.destroy', $this->task));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', $this->task->only(['name']));
    }

    public function testCreatorCanDeleteTask(): void
    {
        $response = $this->actingAs($this->creator)
            ->withSession(['banned' => false])
            ->delete(route('tasks.destroy', $this->task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', $this->task->only(['name']));
    }
}
