<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シンプル掲示板</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', Meiryo, sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
    <!-- ナビゲーションバー -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-2xl">💬</span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">シンプル掲示板</h1>
            </div>
            <a href="#new-post" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-3.5 py-1.5 rounded-full transition-colors">
                ✏️ 投稿する
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8 space-y-8">
        <!-- 成功フラッシュメッセージ -->
        @if (session('success'))
            <div class="flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm animate-fade-in" role="alert">
                <svg class="w-5 h-5 mr-3 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- 新規投稿フォーム -->
        <section id="new-post" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
            <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="p-1.5 bg-indigo-100 text-indigo-600 rounded-lg">✍️</span>
                新規投稿を作成
            </h2>

            <form action="{{ route('posts.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- 名前入力 -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            投稿者名 <span class="text-xs text-slate-400 font-normal">（省略時は「名無しさん」）</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="例: たろう"
                            class="w-full px-4 py-2.5 rounded-xl border @error('name') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- タイトル入力 -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">
                            タイトル <span class="text-xs text-rose-500 font-semibold">*必須</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="タイトルを入力してください"
                            required
                            class="w-full px-4 py-2.5 rounded-xl border @error('title') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition"
                        >
                        @error('title')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 本文入力 -->
                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 mb-1.5">
                        本文 <span class="text-xs text-rose-500 font-semibold">*必須</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="4"
                        placeholder="投稿内容を入力してください..."
                        required
                        class="w-full px-4 py-2.5 rounded-xl border @error('content') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition resize-y"
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 送信ボタン -->
                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition-all duration-150 cursor-pointer"
                    >
                        <span>投稿を送信する</span>
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </section>

        <!-- 投稿一覧 -->
        <section class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span>📋 投稿一覧</span>
                    <span class="text-xs font-semibold px-2 py-0.5 bg-slate-200 text-slate-700 rounded-full">
                        全 {{ $posts->total() }} 件
                    </span>
                </h2>
            </div>

            @if ($posts->isEmpty())
                <!-- 投稿がない場合 -->
                <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center">
                    <span class="text-4xl block mb-3">📭</span>
                    <p class="text-slate-600 font-medium mb-1">まだ投稿がありません</p>
                    <p class="text-xs text-slate-400">一番乗りで新しいメッセージを投稿してみましょう！</p>
                </div>
            @else
                <!-- 投稿リスト -->
                <div class="space-y-4">
                    @foreach ($posts as $post)
                        <article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 hover:border-slate-300 transition duration-150">
                            <!-- 投稿メタ情報 -->
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 mb-1 leading-snug">
                                        {{ $post->title }}
                                    </h3>
                                    <div class="flex items-center gap-3 text-xs text-slate-500">
                                        <span class="inline-flex items-center font-medium text-slate-700">
                                            👤 {{ $post->name }}
                                        </span>
                                        <span>•</span>
                                        <time datetime="{{ $post->created_at->toIso8601String() }}">
                                            🕒 {{ $post->created_at->format('Y/m/d H:i') }}
                                        </time>
                                    </div>
                                </div>

                                <!-- 削除ボタン -->
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('この投稿を削除してもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        title="削除"
                                        class="text-slate-400 hover:text-rose-500 p-1.5 rounded-lg hover:bg-rose-50 transition duration-150"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- 本文 -->
                            <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line bg-slate-50/60 rounded-xl p-4 border border-slate-100">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- ページネーション -->
                <div class="pt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </section>
    </main>

    <footer class="mt-16 py-6 text-center text-xs text-slate-400 border-t border-slate-200">
        Simple Bulletin Board &bull; Laravel {{ app()->version() }}
    </footer>
</body>
</html>
