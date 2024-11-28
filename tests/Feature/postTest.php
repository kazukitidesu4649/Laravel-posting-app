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

    // 未ログインのユーザーは投稿を作成できない。
    public function test_guest_cannot_access_posts_store()
    {
        $post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->post(route('posts.store'), $post);

        $this->assertDatabaseMissing('posts', $post);
        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは投稿を作成できる
    public function test_user_can_access_posts_store()
    {
        $user = User::factory()->create();

        $post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->actingAs($user)->post(route('posts.store'),$post);

        $this->assertDatabaseHas('posts', $post);
        $response->assertRedirect(route('posts.index'));
    }

    // 未ログインのユーザーは投稿編集ページにアクセスできない
    public function test_guest_cannot_access_posts_edit()
    {
        $user = User::factory()->create();
        $Post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('posts.edit, $post'));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは他人の投稿編集ページにアクセスできない
    public function test_user_cannot_access_others_posts_edit()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_post = Post::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->get(route('posts.edit', $others_post));

        $response->assertRedirect(route('posts.index'));
    }

    // ログイン済みのユーザーは自身の投稿編集ページにアクセスできる
    public function test_user_can_access_own_posts_edit()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.edit', $post));

        $response->assertStatus(200);
    }

    // 未ログインのユーザーは投稿を更新できない
    public function test_guest_cannot_update_post()
    {
        $user = User::factory()->create();
        $old_post = Post::factory()->create(['user_id' => $user->id]);

        $new_post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->patch(route('posts.update', $old_post), $new_post);

        $this->assertDatabaseMissing('posts', $new_post);
        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは他人の投稿を更新できない
    public function test_user_cannot_update_others_post()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_old_post = Post::factory()->create(['user_id' => $other_user->id]);

        $new_post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->actingAs($user)->patch(route('posts.update', $others_old_post), $new_post);

        $this->assertDatabaseMissing('posts', $new_post);
        $response->assertRedirect(route('posts.index'));
    }

    // ログイン済みのユーザーは自身の投稿を更新できる
    public function test_user_can_update_own_post()
    {
        $user = User::factory()->create();
        $old_post = Post::factory()->create(['user_id' => $user->id]);

        $new_post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->actingAs($user)->patch(route('posts.update', $old_post), $new_post);

        $this->assertDatabaseHas('posts', $new_post);
        $response->assertRedirect(route('posts.show', $old_post));
    }
}
