<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Requests\PostRequest;

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

    // 作成ページ
    public function create()
    {
        return view('posts.create');
    }

    // 作成機能
    public function store(PostRequest $request)
    {   
        // Postのインスタンス化
        $post = new Post();
        // 変数$postにそれぞれの情報を格納
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = Auth::id();
        // 情報をセーブ
        $post->save();
        
        // 投稿一覧ページにリダイレクト　メッセージが残る
        return redirect()->route('posts.index')->with('flash_message','投稿が完了しました。');
    }
}
