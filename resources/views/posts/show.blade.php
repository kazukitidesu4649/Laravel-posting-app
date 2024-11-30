<!DOCTYPE html>
<html lang="ja">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>投稿詳細</title>
</head>

<body>
    <header>
          <nav>
              <a href="{{ route('posts.index') }}">投稿アプリ</a>

              <ul>
                  <li>
                      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST">
                          @csrf
                      </form>
                  </li>
              </ul>
          </nav>
    </header>

    <main>
        <h1>投稿詳細</h1>

        @if (session('flash_message'))
          <p>{{ session('flash_message') }}</p>
        @endif

        <a href="{{ route('posts.index') }}">&lt; 戻る (投稿一覧へ)</a>

        <article>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>

            @if ($post->user_id === Auth::id())
                <a href="{{ route('posts.edit', $post) }}">編集</a>
                
                <!--削除機能-->
                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm=('本当に削除してもよろしいですか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            @endif
        </article>
    </main>

    <footer>
        <p>&copy; 投稿アプリ All rights reserved.</p>
    </footer>
</body>
</html>