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

                    <!-- {{ __('dashbord(ブログ記事の一覧を表示する)') }} -->
                    @if (session('err_msg'))
                        <p class="text-danger">
                            {{ session('err_msg') }}
                        </p>
                    @endif

                    ユーザーのブログ記事一覧<br>

                    <a href="{{ route('post_create') }}"><button type="button" class="btn btn-secondary">新規ブログ作成</button></a></td>

                    <table class="table" border="1" width="500" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                {{-- <th>記事番号</th> --}}
                                <th>記事タイトル</th>
                                <th>記事本文</th>
                                <th>日付</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                {{-- <td>{{ $article->id }}</td> --}}
                                <td><a href="/show/{{ $article->id }}">{{ $article->title }}</a></td>
                                <td>{{ $article->body }}</td>
                                <td>{{ substr($article->updated_at,0,11) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
