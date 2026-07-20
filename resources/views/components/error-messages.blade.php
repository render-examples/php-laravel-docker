@if ($errors->any())
    <div class="bg-white border border-purple-400 text-purple-700 px-4 py-3 rounded relative mb-4 flex items-start" role="alert">
        <!-- 紫色警告 SVG icon -->
        <svg class="w-6 h-6 flex-shrink-0 mr-3 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"/>
        </svg>
        <div>
            <strong class="font-bold padding-10">錯誤！</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
