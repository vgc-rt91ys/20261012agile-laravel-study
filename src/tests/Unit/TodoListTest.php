<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Services\TodoList;

class TodoListTest extends TestCase
{
    /**
     * Todoを追加できることをテストする
     */
    #[Test]
    public function it_can_complete_a_todo()
    {
        // Arrange
        $todoList = new TodoList();
        $todoList->add('買い物に行く');

        // Act
        $todoList->complete(0); // インデックス0のTodoを完了にする

        // Assert
        $todos = $todoList->getAll();
        $this->assertTrue($todos[0]['completed']);
    }

    /**
     * 未完了のTodoを取得できることをテストする
     */
    #[Test]
    public function it_can_get_incomplete_todos()
    {
        // Arrange
        $todoList = new TodoList();
        $todoList->add('買い物に行く');
        $todoList->add('本を読む');
        $todoList->add('掃除をする');

        // 1つ目を完了にする
        $todoList->complete(0);

        // Act
        $incompleteTodos = $todoList->getIncomplete();

        // Assert
        $this->assertCount(2, $incompleteTodos);
        $this->assertEquals('本を読む', $incompleteTodos[0]['title']);
        $this->assertEquals('掃除をする', $incompleteTodos[1]['title']);
        $this->assertFalse($incompleteTodos[0]['completed']);
        $this->assertFalse($incompleteTodos[1]['completed']);
    }

    /**
     * Todoを削除できることをテストする
     */
    #[Test]
    public function it_can_delete_a_todo()
    {
        // Arrange
        $todoList = new TodoList();
        $todoList->add('買い物に行く');
        $todoList->add('本を読む');

        // Act: インデックス0のTodoを削除
        $todoList->delete(0);

        // Assert
        $todos = $todoList->getAll();
        $this->assertCount(1, $todos);
        $this->assertEquals('本を読む', $todos[0]['title']);
    }

    /**
     * タイトルでTodoを検索できることをテストする
     */
    #[Test]
    public function it_can_search_todos_by_title()
    {
        // Arrange
        $todoList = new TodoList();
        $todoList->add('Laravelの勉強');
        $todoList->add('PHPの基礎');
        $todoList->add('Laravelのテスト');

        // Act: 'Laravel' を含むTodoを検索
        $results = $todoList->search('Laravel');

        // Assert
        $this->assertCount(2, $results);
        $this->assertEquals('Laravelの勉強', $results[0]['title']);
        $this->assertEquals('Laravelのテスト', $results[1]['title']);
    }
}