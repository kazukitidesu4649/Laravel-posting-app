<!DOCTYPE html>
<html lang="ja">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>投稿編集</title>
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
        <h1>投稿編集</h1>

        @if ($errors->any())
             <ul>
                 @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                 @endforeach
             </ul>
         @endif
 
         <a href="{{ route('posts.index') }}">&lt; 戻る</a>
         
        <form action="{{ route('posts.update', $post) }}" method="POST">
             @csrf
             @method('PATCH')
             <div>
                 <label for="title">タイトル</label>
                 <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}">
             </div>
             <div>
                 <label for="content">本文</label>
                 <textarea id="content" name="content">{{ old('content', $post->content) }}</textarea>
             </div>
             <button type="submit">更新</button>
         </form>

        <footer>
            <p>&copy; 投稿アプリ All rights reserved.</p>
        </footer>
    </main>
</body>