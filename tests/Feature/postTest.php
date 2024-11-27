<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class postTest extends TestCase
{
    use RefreshDatabase;

    // ログインしていないユーザーは投稿一覧一覧ページにアクセス出来ない
    public function test_guest_cannot_access_posts_index()
    {
        $response = $this->get(route('posts.index'));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは投稿詳細ページにアクセスできない
    public function test_user_can_access_posts_index()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee($post->title);

    }

    // 未ログインのユーザーは投稿詳細ページにアクセスできない
    public function test_guest_cannnot_access_posts_show()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=> $user->id]);

        $response = $this->get(route('posts.show', $post));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みユーザーは投稿詳細ページにアクセスできる
    public function test_use_can_access_posts_show()
    {
        $user = User::factory()->create();
        $post  =Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.show', $post));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    // 未ログインのユーザーは新規投稿ページにアクセスできない
    public function test_guest_cannot_access_posts_create()
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは新規投稿ページにアクセスできる
    public function test_user_can_access_posts_create()
    {
        // ユーザーファクトリを使ってテスト用のユーザーを作成
        $user = User::factory()->create();

        // $this->actingAs($user)テストリクエストを行う前に、作成されたユーザーで認証された状態を試す。
        $response = $this->actingAs($user)->get(route('posts.create'));

        // HTTPステータス200 = OK であること。
        // つまり、ページが正常である事
        $response->assertStatus(200);
    }
}
