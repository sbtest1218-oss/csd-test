<?php

namespace Tests\Unit;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Todoを作成できることをテストする
     */
    #[Test]
    public function it_can_create_a_todo()
    {
        // Arrange & Act
        $todo = Todo::create([
            'title' => '買い物に行く',
            'completed' => false,
        ]);

        // Assert
        $this->assertDatabaseHas('todos', [
            'title' => '買い物に行く',
            'completed' => false,
        ]);

        $this->assertEquals('買い物に行く', $todo->title);
        $this->assertFalse($todo->completed);
    }
}
