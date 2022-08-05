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
                            <a href="/edit/{{ $article->id }}"><button type="button" class="btn btn-secondary">編集</button></a></td>
                            <a href=""><button type="button" class="btn btn-secondary">削除</button></a></td>
                            <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">ブログの一覧に戻る</button></a></td>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
