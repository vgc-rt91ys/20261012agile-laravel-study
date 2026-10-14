<?php

namespace App\Services;

class TodoList
{
    private array $todos = [];

    /**
     * Todoを追加する
     */
    public function add(string $title): void
    {
        $this->todos[] = [
            'title' => $title,
            'completed' => false,
        ];
    }

    /**
     * 全てのTodoを取得する
     */
    public function getAll(): array
    {
        return $this->todos;
    }
    /**
     * Todoを完了にする
     */
    public function complete(int $index): void
    {
        if (isset($this->todos[$index])) {
            $this->todos[$index]['completed'] = true;
        }
    }

    /**
     * 未完了のTodoを取得する
     */
    public function getIncomplete(): array
    {
        return array_values(array_filter($this->todos, fn($todo) => !$todo['completed']));
    }

    /**
     * Todoを削除する
     */
    public function delete(int $index): void
    {
        if (isset($this->todos[$index])) {
            array_splice($this->todos, $index, 1);
        }
    }

    /**
     * Todoを削除する（deleteのエイリアス）
     */
    public function remove(int $index): void
    {
        $this->delete($index);
    }

    /**
     * タイトルでTodoを検索する（部分一致）
     */
    public function search(string $keyword): array
    {
        return array_values(array_filter($this->todos, function ($todo) use ($keyword) {
            return str_contains($todo['title'], $keyword);
        }));
    }

    /**
     * searchのエイリアス
     */
    public function searchByTitle(string $keyword): array
    {
        return $this->search($keyword);
    }
}