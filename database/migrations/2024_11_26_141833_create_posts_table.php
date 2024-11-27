<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // 投稿ID
            $table->foreignID('user_id')->constrained()->cascadeOnDelete(); // ユーザーID
            $table->string('title'); // 投稿のタイトル
            $table->string('content'); // 投稿の内容
            $table->timestamps(); // 作成・更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
