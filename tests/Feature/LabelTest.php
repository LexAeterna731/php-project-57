<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;
    private array $data;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
        $this->label = Label::factory()->create();
        $this->data = [
            'name' => 'testTask',
            'description' => 'test description',            
        ];
        $this->labelWithTask = Label::factory()
            ->has(Task::factory()->count(2))
            ->create();
    }

    public function test_labels_screen_can_be_rendered(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertStatus(200);
    }

    public function test_label_create_screen_can_be_rendered_for_user(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('labels.create'));

        $response->assertStatus(200);
    }

    public function test_label_create_screen_cant_be_rendered_for_guest(): void
    {
        $response = $this->get(route('labels.create'));

        $response->assertStatus(403);       
    }

    public function test_user_can_create_label(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->post(route('labels.store', $this->data));
        
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->data);
    }

    public function test_guest_cant_create_label(): void
    {
        $response = $this->post(route('labels.store', $this->data));
        
        $response->assertStatus(403);
        $this->assertDatabaseMissing('labels', $this->data);
    }

    public function test_label_edit_screen_can_be_rendered_for_user(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('labels.edit', $this->label));

        $response->assertStatus(200);
    }

    public function test_label_edit_screen_cant_be_rendered_for_guest(): void
    {
        $response = $this->get(route('labels.edit', $this->label));

        $response->assertStatus(403);         
    }

    public function test_user_can_edit_label(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->put(route('labels.update', $this->label), $this->data);
        
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->data);
    }

    public function test_guest_cant_edit_label(): void
    {
        $response = $this->put(route('labels.update', $this->label), $this->data);
        
        $response->assertStatus(403);
        $this->assertDatabaseMissing('labels', $this->data);
    }

    public function test_guest_cant_delete_label(): void
    {
        $response = $this->delete(route('labels.destroy', $this->label));

        $response->assertStatus(403);
        $this->assertDatabaseHas('labels', $this->label->only(['name']));
    }

    public function test_user_cant_delete_label_with_task(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('labels.destroy', $this->labelWithTask));
        
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->labelWithTask->only(['name']));;
    }

    public function test_user_can_delete_label(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('labels.destroy', $this->label));
        
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', $this->label->only(['name']));
    }
}
