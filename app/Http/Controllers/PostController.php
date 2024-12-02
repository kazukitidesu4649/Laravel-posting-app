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
        $posts = Auth::user()->posts()->orderBy('updated_at', 'asc')->get();

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
        //バリデーションを設定する
        $request->validate([
            'title' => 'required|max:40',
            'content' => 'required|max:200'
        ]);

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

    // 編集ページ   
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
        }

        return view('posts.edit', compact('post'));
    }

    // 更新機能
    public function update(PostRequest $request, Post $post)
     {
         if ($post->user_id !== Auth::id()) {
             return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
         }

         //バリデーションを設定する
        $request->validate([
            'title' => 'required|max:40',
            'content' => 'required|max:200'
        ]);
 
         $post->title = $request->input('title');
         $post->content = $request->input('content');
         $post->save();
 
         return redirect()->route('posts.show', $post)->with('flash_message', '投稿を編集しました。');
     }

     // 削除機能
     public function destroy(Post $post) {
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('flash_message', '投稿を削除しました。');
     }
}
