<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新增產品') }}
        </h2>
    </x-slot>

    <div class="w-[90%] mx-auto p-6 bg-white shadow-lg rounded-2xl mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">新增產品</h2>

        <form action="{{ route('product.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 產品名稱 -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">產品名稱</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- 價格 -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">價格</label>
                <input type="number" name="price" id="price" step="0.01" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- 庫存數量 -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">庫存數量</label>
                <input type="number" name="amount" id="amount" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- 類別 -->
            <!-- <div>
                <label for="category" class="block text-sm font-medium text-gray-700">產品類別</label>
                <select name="category" id="category"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">請選擇</option>
                    <option value="electronic">電子產品</option>
                    <option value="apparel">服飾</option>
                    <option value="food">食品</option>
                </select>
            </div> -->

            <!-- 描述 -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">產品描述</label>
                <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <!-- 提交按鈕 -->
            <div class="text-left">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                        bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 ">
                        新增
                </button>
            </div>
        </form>
    </div>

</x-app-layout>