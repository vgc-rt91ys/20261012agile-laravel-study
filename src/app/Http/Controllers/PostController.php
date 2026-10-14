<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * 投稿一覧＆フォーム画面を表示
     */
    public function index(): View
    {
        $posts = Post::latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * 新規投稿を保存
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:30',
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:2000',
        ], [
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは100文字以内で入力してください。',
            'content.required' => '本文を入力してください。',
            'content.max' => '本文は2000文字以内で入力してください。',
            'name.max' => '名前は30文字以内で入力してください。',
        ]);

        // 名前が空文字・nullの場合は「名無しさん」にする
        if (empty($validated['name'])) {
            $validated['name'] = '名無しさん';
        }

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', '掲示板に投稿しました！');
    }

    /**
     * 投稿を削除
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿を削除しました。');
    }
}
