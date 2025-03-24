<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>投稿詳細</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        .edit-shop-content {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .edit-shop-content a, 
        .edit-shop-content form {
            display: inline-block;
        }
        .edit-button {
            background-color: #ffc107;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .edit-button:hover {
            background-color: #e0a800;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .post {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .post img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .post h2 {
            color: #007bff;
            font-size: 24px;
        }
        .post p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
        }
        .tag {
            background-color: #007bff;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        .likes {
            font-size: 18px;
            color: red;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .review {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        .review p {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .stars {
            display: flex;
            justify-content: center;
        }
        .stars span {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .stars input[type='radio'] {
            display: none;
        }
        .stars label {
            color: #D2D2D2;
            font-size: 30px;
            padding: 0 5px;
            cursor: pointer;
            transition: color 0.3s;
        }
        .stars label:hover,
        .stars label:hover ~ label,
        .stars input[type='radio']:checked ~ label {
            color: #F8C601;
        }
        .slick-slider div {
            text-align: center; /* スライドの中身を中央揃え */
        }
        .slick-slider img {
            display: block;
            margin: 0 auto;
            width: auto; /* 幅を自動調整 */
            max-width: 100%; /* コンテナの幅を超えないように */
            height: auto; /* 高さを自動調整 */
            max-height: 300px; /* 最大高さを300pxに制限 */
            object-fit: contain; /* 縦横比を維持して画像を表示 */
            border-radius: 8px;
        }
        .slick-prev, .slick-next {
            font-size: 0; /* デフォルトのテキストを非表示 */
            width: 40px;
            height: 40px;
            z-index: 1000;
        }
        .slick-prev::before, .slick-next::before {
            font-size: 30px;
            color: #007bff; /* 矢印の色を変更 */
            opacity: 1; /* デフォルトで見えるように */
        }
        .slick-prev:hover::before, .slick-next:hover::before {
            color: #0056b3; /* ホバー時に色を少し濃く */
        }
    </style>
    <script>
        function confirmDelete(event) {
            if (!confirm('本当に削除しますか？')) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>投稿詳細</h1>
        <div class="edit-shop-content">
            <a href="{{ route('edit', ['id' => $shopDetail['id']]) }}" class="edit-button">
                ✏ 編集する
            </a>
            <form action="{{ route('delete', ['id' => $shopDetail['id']]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">🗑 削除する</button>
            </form>
        </div>
        <div class="post">
            @if(!is_null($images[0]['image_url']))
                <div class="slick-slider">
                    @foreach($images as $image)
                        <div><img src="{{ $image['image_url'] }}" alt="画像"></div>
                    @endforeach
                </div>
            @elseif(is_null($images[0]['image_url']))
                <div class="slick-slider">
                    <div><img src="https://picsum.photos/200/300" alt="画像"></div>
                </div>
            @endif
            <h2>{{ $shopDetail['shopname'] }}</h2>
            <p>評価: <strong>{{ number_format($shopDetail['avg_rating'], 1) }}</strong> ⭐</p>
            <p>住所: {{ $shopDetail['address'] }}</p>
            
            @if (!empty($shopDetail['tags']))
                <div class="tags">
                    @foreach ($shopDetail['tags'] as $tag)
                        <span class="tag">{{ $tag['name'] }}</span>
                    @endforeach
                </div>
            @endif

            <p class="likes">❤️</p>
        </div>
        <a href="{{ route('index') }}" class="back-link">一覧に戻る</a>
    </div>
    <div class="review">
        <p>レビュー</p>
        <div class="stars">
            <span>
                <input id="review01" type="radio" name="review" value="5">
                <label for="review01">★</label>
                <input id="review02" type="radio" name="review" value="4">
                <label for="review02">★</label>
                <input id="review03" type="radio" name="review" value="3">
                <label for="review03">★</label>
                <input id="review04" type="radio" name="review" value="2">
                <label for="review04">★</label>
                <input id="review05" type="radio" name="review" value="1">
                <label for="review05">★</label>
            </span>
            <input type="hidden" name="postId" value="{{ $shopDetail['id'] }}">
        </div>
    </div>
</body>
</html>
