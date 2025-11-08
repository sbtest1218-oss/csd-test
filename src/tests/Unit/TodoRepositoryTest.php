<?php

namespace Tests\Unit;

use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TodoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TodoRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TodoRepository();
    }

    /**
     * Todoを作成できることをテストする
     */
    #[Test]
    public function it_can_create_a_todo()
    {
        // Arrange & Act
        $todo = $this->repository->create('買い物に行く');

        // Assert
        $this->assertDatabaseHas('todos', [
            'title' => '買い物に行く',
            'completed' => false,
        ]);
        $this->assertInstanceOf(Todo::class, $todo);
    }

    /**
     * 全Todoを取得できることをテストする
     */
    #[Test]
    public function it_can_get_all_todos()
    {
        // Arrange
        Todo::create(['title' => '買い物']);
        Todo::create(['title' => '掃除']);

        // Act
        $todos = $this->repository->getAll();

        // Assert
        $this->assertCount(2, $todos);
    }

    /**
     * Todoを完了にできることをテストする
     */
    #[Test]
    public function it_can_complete_a_todo()
    {
        // Arrange
        $todo = Todo::create(['title' => '買い物']);

        // Act
        $this->repository->complete($todo->id);

        // Assert
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'completed' => true,
        ]);
    }

    /**
     * 未完了Todoだけを取得できることをテストする
     */
    #[Test]
    public function it_can_get_pending_todos()
    {
        // Arrange
        Todo::create(['title' => '買い物']);
        $completed = Todo::create(['title' => '掃除']);
        $completed->update(['completed' => true]);

        // Act
        $pending = $this->repository->getPending();

        // Assert
        $this->assertCount(1, $pending);
        /** @var \App\Models\Todo $firstPending */
        $firstPending = $pending[0];
        $this->assertEquals('買い物', $firstPending->title);
    }

    /**
     * Todoを削除できることをテストする
     */
    #[Test]
    public function it_can_delete_a_todo()
    {
        // Arrange
        $todo = Todo::create(['title' => '買い物']);

        // Act
        $this->repository->delete($todo->id);

        // Assert
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }
}
