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
                            <a href="/edit/{{ $article->id }}"><button type="button" class="btn btn-secondary">編集</button></a></td>
                            <a href=""><button type="button" class="btn btn-secondary">削除</button></a></td>
                            <p>作成日：{{ $article->created_at }}
                                更新日：{{ $article->updated_at }}</更新日：>
                            <p>{{ $article->body }}</p>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
