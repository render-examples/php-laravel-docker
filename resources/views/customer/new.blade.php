<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新增客戶') }}
        </h2>
    </x-slot>

    <div class="w-[90%] mx-auto p-6 bg-white shadow-lg rounded-2xl mt-8">

        <form action="{{ route('customer.store') }}" method="POST" class="space-y-6">
            @csrf

        <!-- 客戶名稱 -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">客戶名稱</label>
            <input type="text" name="name" id="name" required
                value="{{ old('name') }}"
                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <!-- 電話 -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">電話</label>
            <input type="text" name="phone" id="phone" required
                value="{{ old('phone') }}"
                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <!-- 統編號碼 -->
        <div>
            <label for="taxIdNumber" class="block text-sm font-medium text-gray-700">統編號碼</label>
            <input type="text" name="taxIdNumber" id="taxIdNumber" required
                value="{{ old('taxIdNumber') }}"
                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <!-- 地址 -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">地址</label>
            <textarea name="address" id="address" rows="4"
                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('address') }}</textarea>
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