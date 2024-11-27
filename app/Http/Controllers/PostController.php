<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    //一覧ページ
    public function index()
    {
        // 認証済みのユーザーが所用する投稿を取得し、作成日時を降順で並べて取得する。
        $posts = Auth::user()->posts()->orderBy('created_at', 'desc')->get();

        // posts/index.blade.phpに $posts(compact('posts'))に渡す。
        // bladeテンプレート内で$postsを使用できる様になる。
        return view('posts.index',compact('posts'));
    }

    // 詳細ページ show(Post $post)=Postモデルのインスタンスを取得
    public function show(Post $post)
    {
        // show.blade.phpテンプレートに$postを渡す。
        return view('posts.show', compact('post'));
    }
}
