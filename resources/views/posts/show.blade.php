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
                      <a href="{{ route('logout') }}" onclick="event.preventDefault.getElementById('logout-form').submit();">ログアウト</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST">
                          @csrf
                      </form>
                  </li>
              </ul>
          </nav>
    </header>

    <main>
        <h1>投稿詳細</h1>
        <a href="{{ route('posts.index') }}">&lt; 戻る</a>

        <article>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
        </article>
    </main>

    <footer>
        <p>&copy; 投稿アプリ All rights reserved.</p>
    </footer>
</body>
</html>