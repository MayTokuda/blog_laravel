@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('User一覧') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">自分のブログ一覧(全て)</button></a></td><br>

                    メンバーの一覧画面です！ 

                    <table  class="table_article" width="70%" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>ユーザー名</th>
                                <th>記事タイトル</th>
                                <th>写真</th>
                                <th>記事本文</th>
                                <th>日付</th>
                                <th>タグ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td><a href="/profile/{{$item->user->id}}">{{ $item->user->name }}</td>
                                    <td><a href="/show/{{ $item->id }}">{{ Str::limit( $item->title, 20, '...') }}</td>
                                    <td><img class="article-img" src="{{ \Storage::url($item->image) }}" width="75vw"></td>
                                    <td>{{ Str::limit( $item->body, 25, '...') }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        @foreach($item->tags as $tag)
                                            <td>{{ $tag->name }}</td>
                                        @endforeach
                                </tr>
                            @endforeach
                        </tbody>   
                    </table>

                    <table  class="table_tag" width="20%" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>タグの種類</th>
                            </tr>
                        </thead>
                        <tbody>

                        <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td><a href="/allsearch/{{ $tag->name }}">{{ $tag->name }}({{ $tag->count_name }})</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 

                    <table  class="table_date" width="20%" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>日付</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($days as $day)
                            <tr>
                                <td><a href="/allsearch_time/{{ $day->date }}">{{ $day->date }}</a></td>
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
