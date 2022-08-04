<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{ route('update') }}" method="post">
    @csrf 
    <dl class="form-list">
        <dt>画像</dt>
        <dd><input type="file" name="image" accept="image/png,image/jpeg"></dd>
        <dt>タイトル</dt>
        <dd><input type="text" name="title"></dd>
        <dt>タグ</dt>
        <dd><input type="text" name="tag"></dd>
        <dt>本文</dt>
        <dd><textarea name="body"></textarea></dd>
    </dl>
    <button type="submit">投稿する</button>
    <a href="{{ route('dashbord') }}">キャンセル</a>
</form>
</body>
</html>
