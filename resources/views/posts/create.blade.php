<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗登録</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            background-color: #f1f3f5;
        }
        
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background: #f8f9fa;
        }
        
        select {
            height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>店舗登録</h1>
        <form action="{{ route('store') }}" method="POST">
            @csrf
            <div>
                <label for="shopname">店舗名:</label>
                <input type="text" id="shopname" name="shopname" required>
            </div>
            <div>
                <label for="address">住所:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div>
                <label for="tags">タグ:</label>
                <select id="tags" name="tags[]" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag['id']}}">{{ $tag['name']}}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="confirm" value="confirm" />
            <div>
                <button type="submit">確認する</button>
            </div>
        </form>
    </div>
</body>
</html>
