<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗更新確認</title>
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
        
        .info {
            font-size: 16px;
            margin-bottom: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .back {
            background-color: #6c757d;
            color: white;
            margin-right: 10px;
        }
        
        .back:hover {
            background-color: #5a6268;
        }
        
        .submit {
            background-color: #007bff;
            color: white;
        }
        
        .submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>店舗更新確認</h1>
        <div>
            <p class="info"><strong>店舗名:</strong> {{ $inputData['shopname'] }}</p>
            <p class="info"><strong>住所:</strong> {{ $inputData['address'] }}</p>
            <p class="info"><strong>タグ:</strong> 
                @foreach ($tags as $tag)
                    {{ $tag['name']; }}
                @endforeach
            </p>
        </div>
        <form action="{{ route('update') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="shopname" value="{{ $inputData['shopname'] }}">
            <input type="hidden" name="address" value="{{ $inputData['address'] }}">
            @foreach ($tags ?? [] as $tag)
                <input type="hidden" name="tags[]" value="{{ $tag['id'] }}">
            @endforeach
            <input type="hidden" name="complete" value="complete">
            <input type="hidden" name="id" value="{{ $inputData['id'] }}"/>
            <div class="buttons">
                <button type="button" class="back" onclick="history.back()">修正する</button>
                <button type="submit" class="submit">更新する</button>
            </div>
        </form>
    </div>
</body>
</html>
