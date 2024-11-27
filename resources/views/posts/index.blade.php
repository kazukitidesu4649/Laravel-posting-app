<!DOCTYPE html>
<html lang="ja">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width", initial-scale="1.0">
      <title>投稿一覧</title>
</head>

<body>
    <header>
        <nav>
            <a href="{{ route('posts.index') }}">投稿アプリ</a>

            <ul>
                <li>
                    <a href="{{ route('logout') }} onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <form id="logout-form" action="{{  route('logout') }}" method="POST">
                      @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>投稿一覧</h1>
        
        <!-- sessionへルパ関数を用い、if文でflash_messageを表示 -->
        @if (session('flash_message'))
          <p>{{ session('flash_message') }}</p>
        @endif
        
        @if ($posts->isNotEmpty())
          @foreach ($posts as $post)
            <article>
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->content }}</p>
                <a href="{{ route('posts.show', $post) }}">詳細</a>
            </article>
          
          @endforeach
        
        @endif
    </main>
</body>
</html>