@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- {{ __('show(記事を詳細に表示する)') }} -->
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2>{{ $article->title }}</h2>
                            <img class="article-img" src="{{ \Storage::url($article->image) }}" alt="" width="100%">
                            <p>{{ $article->body }}</p>
                            <p>タグ：{{ $article->tags()->value('name') }}</p>
                            <p>作成日：{{ substr($article->created_at,0,11) }} &ensp;&ensp; 更新日：{{ substr($article->updated_at,0,11) }}</p>

                            {{-- ログインしたユーザーのみ表示 --}}
                            @if (Auth::id() === $article->user_id)

                            <a href="/edit/{{ $article->id }}"><button type="button" class="btn btn-secondary">編集</button></a>                                                          
                            
                            <form action="{{ route('delete', ['id' => $article->id ] ) }}"  method="POST"  id="delete_{{ $article->id }}">
                            @csrf 
                            <a href="#" class="btn btn-secondary" data-id="{{ $article->id }}" onclick="deletePost(this);" >削除</button>
                            </form>
                            
                            
                            @endif

                            <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">自分のブログの一覧に戻る</button></a></td>
                            <a href="{{ route('other_users') }}"><button type="button" class="btn btn-secondary">メンバーのブログ一覧に戻る</button></a></td>
                            <button type="button" class="btn btn-secondary" onClick="history.back()">一つ前の画面に戻る</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deletePost(e) {
    'use strict';
    if (confirm('本当にこの記事を削除してもいいですか？')){
    document.getElementById('delete_' + e.dataset.id).submit();
    }
}
</script>

@endsection
