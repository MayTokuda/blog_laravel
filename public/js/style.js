// 1. ファイル選択後に呼ばれるイベント
$("#input1").on("change", function (e) {

    // 2. 画像ファイルの読み込みクラス
    var reader = new FileReader();

    // 3. 準備が終わったら、id=sample1のsrc属性に選択した画像ファイルの情報を設定
    reader.onload = function (e) {
        $("#sample1").attr("src", e.target.result);
    }

    // 4. 読み込んだ画像ファイルをURLに変換
    reader.readAsDataURL(e.target.files[0]);
});