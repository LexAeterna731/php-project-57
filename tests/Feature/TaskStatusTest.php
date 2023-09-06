<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $taskStatus;
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->data = ['name' => 'testStatus'];
    }

    public function test_task_statuses_screen_can_be_rendered(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
    }

    public function test_task_status_create_screen_can_be_rendered_for_user(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('task_statuses.create'));

        $response->assertStatus(200);
    }

    public function test_task_status_create_screen_cant_be_rendered_for_guest(): void
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertStatus(403);       
    }

    public function test_user_can_create_task_status(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->post(route('task_statuses.store', $this->data));
        
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $this->data);
    }

    public function test_guest_cant_create_task_status(): void
    {
        $response = $this->post(route('task_statuses.store', $this->data));
        
        $response->assertStatus(403);
        $this->assertDatabaseMissing('task_statuses', $this->data);
    }

    public function test_task_status_edit_screen_can_be_rendered_for_user(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertStatus(200);
    }

    public function test_task_status_edit_screen_cant_be_rendered_for_guest(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertStatus(403);         
    }

    public function test_user_can_edit_task_status(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->put(route('task_statuses.update', $this->taskStatus), $this->data);
        
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $this->data);
    }

    public function test_guest_cant_edit_task_status(): void
    {
        $response = $this->put(route('task_statuses.update', $this->taskStatus), $this->data);
        
        $response->assertStatus(403);
        $this->assertDatabaseMissing('task_statuses', $this->data);
    }

    public function test_guest_cant_delete_task_status(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertStatus(403);
        $this->assertDatabaseHas('task_statuses', $this->taskStatus->only(['name']));
    }

    public function test_user_can_delete_task_status(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('task_statuses.destroy', $this->taskStatus));
        
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', $this->taskStatus->only(['name']));
    }
}
