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
    private Label $labelWithTask;
    private array $data;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
        $this->data = [
            'name' => 'testTask',
            'description' => 'test description',
        ];
        $this->labelWithTask = Label::factory()
            ->has(Task::factory()->count(2))
            ->create();
    }

    public function testLabelsScreenCanBeRendered(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertStatus(200);
    }

    public function testLabelCreateScreenCanBeRenderedForUser(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('labels.create'));

        $response->assertStatus(200);
    }

    public function testLabelCreateScreenCantBeRenderedForGuest(): void
    {
        $response = $this->get(route('labels.create'));

        $response->assertStatus(403);
    }

    public function testUserCanCreateLabel(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->post(route('labels.store', $this->data));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->data);
    }

    public function testGuestCantCreateLabel(): void
    {
        $response = $this->post(route('labels.store', $this->data));

        $response->assertStatus(403);
        $this->assertDatabaseMissing('labels', $this->data);
    }

    public function testLabelEditScreenCanBeRenderedForUser(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->get(route('labels.edit', $this->label));

        $response->assertStatus(200);
    }

    public function testLabelEditScreenCantBeRenderedForGuest(): void
    {
        $response = $this->get(route('labels.edit', $this->label));

        $response->assertStatus(403);
    }

    public function testUserCanEditLabel(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->put(route('labels.update', $this->label), $this->data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->data);
    }

    public function testGuestCantEditLabel(): void
    {
        $response = $this->put(route('labels.update', $this->label), $this->data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('labels', $this->data);
    }

    public function testGuestCantDeleteLabel(): void
    {
        $response = $this->delete(route('labels.destroy', $this->label));

        $response->assertStatus(403);
        $this->assertDatabaseHas('labels', $this->label->only(['name']));
    }

    public function testUserCantDeleteLabelWithTask(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('labels.destroy', $this->labelWithTask));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->labelWithTask->only(['name']));
    }

    public function testUserCanDeleteLabel(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->delete(route('labels.destroy', $this->label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', $this->label->only(['name']));
    }
}
