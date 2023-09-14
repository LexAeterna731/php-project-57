<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $taskStatus;
    private TaskStatus $taskStatusWithTask;
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->data = ['name' => 'testStatus'];
        $this->taskStatusWithTask = TaskStatus::factory()
            ->has(Task::factory()->count(2))
            ->create();
    }

    public function testTaskStatusesScreenCanBeRendered(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
    }

    public function testTaskStatusCreateScreenCanBeRenderedForUser(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('task_statuses.create'));

        $response->assertStatus(200);
    }

    public function testTaskStatusCreateScreenCantBeRenderedForGuest(): void
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertStatus(403);
    }

    public function testUserCanCreateTaskStatus(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->post(route('task_statuses.store', $this->data));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $this->data);
    }

    public function testGuestCantCreateTaskStatus(): void
    {
        $response = $this->post(route('task_statuses.store', $this->data));

        $response->assertStatus(403);
        $this->assertDatabaseMissing('task_statuses', $this->data);
    }

    public function testTaskStatusEditScreenCanBeRenderedForUser(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertStatus(200);
    }

    public function testTaskStatusEditScreenCantBeRenderedForGuest(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertStatus(403);
    }

    public function testUserCanEditTaskStatus(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->put(route('task_statuses.update', $this->taskStatus), $this->data);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $this->data);
    }

    public function testGuestCantEditTaskStatus(): void
    {
        $response = $this->put(route('task_statuses.update', $this->taskStatus), $this->data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('task_statuses', $this->data);
    }

    public function testGuestCantDeleteTaskStatus(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertStatus(403);
        $this->assertDatabaseHas('task_statuses', $this->taskStatus->only(['name']));
    }

    public function testUserCantDeleteTaskStatusWithTask(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('task_statuses.destroy', $this->taskStatusWithTask));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $this->taskStatusWithTask->only(['name']));
    }

    public function testUserCanDeleteTaskStatus(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', $this->taskStatus->only(['name']));
    }
}
