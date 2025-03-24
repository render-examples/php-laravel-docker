<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿一覧</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            background-color: #f1f3f5;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
        }

        h2 a {
            display: inline-block;
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            background-color: #f0f0f0;
            transition: background-color 0.3s;
        }

        h2 a:hover {
            background-color: #e2e6ea;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .create-shop-content {
            text-align: center; 
            margin-bottom: 20px;
        }

        .create-shop-content a {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .post {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 12px;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .post img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 12px;
        }

        .post-content {
            flex: 1;
        }

        .post h2 {
            margin: 0 0 8px;
            font-size: 18px;
            color: #343a40;
        }

        .post p {
            margin: 5px 0;
            font-size: 14px;
            color: #495057;
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 8px;
        }

        .tag {
            background-color: #6c757d;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .likes {
            font-size: 16px;
            color: #e74c3c;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            margin: 0 4px;
            padding: 6px 10px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }

        .pagination .active {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>投稿一覧</h1>
        <div class="create-shop-content">
            <a href="{{ route('create') }}">
                ＋ 新しい店舗を追加
            </a>
        </div>
        @foreach ($shopData as $post)
            <div class="post">
                @if(!is_null($post['image_url']))
                    <div><img src="{{ $post['image_url'] }}" alt="画像"></div>
                @elseif(is_null($post['image_url']))
                    <div><img src="https://picsum.photos/200/300" alt="画像"></div>
                @endif
                <div class="post-content">
                    <h2><a href="{{ route('show', ['id' => $post['id']]) }}">{{ $post['shopname'] }}</a></h2>
                    <p>評価: <strong>{{ number_format($post['avg_rating'], 1) }}</strong> ⭐</p>

                    <!-- タグ表示 -->
                    @if (!empty($post['tags']))
                        <div class="tags">
                            @foreach ($post['tags'] as $tag)
                                <span class="tag">{{ $tag['name'] }}</span>
                            @endforeach
                        </div>
                    @endif

                    <!-- いいね（ハート）表示 -->
                    <p class="likes">❤️</p>
                </div>
            </div>
        @endforeach

        <!-- ページネーション -->
        <div class="pagination">
            @for ($i = 1; $i <= $pagerInfo['maxPage']; $i++)
                @if ($i == $pagerInfo['nowPage'])
                    <span class="active">{{ $i }}</span>
                @else
                    <a href="?page_id={{ $i }}">{{ $i }}</a>
                @endif
            @endfor
        </div>
    </div>
</body>
</html>
