@section('jshead')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productlist = @json($productjs); 
        const tbody = document.getElementById('items');
        const subtotalEl = document.getElementById('subtotal');
        const taxEl = document.getElementById('tax');
        const totalEl = document.getElementById('total');
        let row = 1;

        // 重新計算所有小計的總和、稅金、總金額
        function updateTotal() {
            let totalSubtotal = 0;
            tbody.querySelectorAll('tr').forEach(row => {
                const sub = parseFloat(row.querySelector('.subtotal')?.textContent || 0);
                totalSubtotal += sub;
            });

            const tax = Math.round(totalSubtotal * 0.05); // 5% 稅金，可依需求調整
            const total = totalSubtotal + tax;

            subtotalEl.textContent = `$${totalSubtotal}`;
            taxEl.textContent = `$${tax}`;
            totalEl.textContent = `$${total}`;
        }

        // 更新單一列的小計（單價 * 數量）
        function updateSubtotal(rowEl) {
            const productSelect = rowEl.querySelector('select');
            const quantityInput = rowEl.querySelector('input[name$="[quantities]"]');
            const subtotalSpan = rowEl.querySelector('.subtotal');

            const productId = productSelect.value;
            const price = productlist[productId]?.price || 0;
            const quantity = parseFloat(quantityInput.value) || 0;
            const subtotal = price * quantity;

            subtotalSpan.textContent = subtotal;

            updateTotal(); // 每次更新小計都更新總計
        }

        // 綁定事件：產品變動時
        tbody.addEventListener('change', function (e) {
            if (e.target.tagName === 'SELECT') {
                const rowEl = e.target.closest('tr');
                updateSubtotal(rowEl);
            }
        });

        // 綁定事件：數量變動時
        tbody.addEventListener('input', function (e) {
            if (e.target.name.includes('[quantities]')) {
                const rowEl = e.target.closest('tr');
                updateSubtotal(rowEl);
            }
        });

        // 新增一列商品
        document.getElementById("addProduct").addEventListener('click', function () {
            const trEl = document.createElement('tr');
            trEl.innerHTML = `
                <td class="border p-2">
                    <select name="products[${row}][product_id]" class="w-full border-gray-300 rounded">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border p-2 text-right">
                    <input type="number" name="products[${row}][quantities]" value="1" class="w-20 text-right border-gray-300 rounded">
                </td>
                <td class="border p-2 text-right">
                    <span class="subtotal">0</span>
                </td>
            `;
            tbody.appendChild(trEl);
            updateSubtotal(trEl);
            row++;
        });

        // 頁面載入後先更新一次
        updateSubtotal(tbody.querySelector('tr'));
    });
</script>
@endsection



<x-app-layout>
    <form action="{{ route('order.store') }}" method="post">
    @csrf
        
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新增產品') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-4">新增訂單</h2>

        <!-- 客戶與訂單資訊 -->
        <div class="grid grid-cols-3 gap-4 mb-6">
        <div>
            <label for="customer" class="block text-sm font-medium text-gray-700">選擇客戶</label>
            <select id="customer" name="customer" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm">
            <option value="">-</option>
            @foreach($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            <!-- <option>陳大文</option> -->
            @endforeach
            </select>
        </div>
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">日期</label>
            <input type="date" id="date" name="date" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm">
        </div>
        <!-- <div>
            <label for="order_number" class="block text-sm font-medium text-gray-700">訂單編號</label>
            <input type="text" id="order_number" name="order_number" value="O13535678" readonly class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100">
        </div> -->
        </div>

        <!-- 商品項目列表 -->
        <table class="w-full text-sm border border-gray-300 mb-4">
        <thead class="bg-gray-50">
            <tr>
            <th class="border p-2 text-left">商品</th>
            <th class="border p-2 text-right">數量</th>
            <!-- <th class="border p-2 text-right">單價</th> -->
            <th class="border p-2 text-right">小計</th>
            </tr>
        </thead>
        <tbody id="items">
            <tr>
            <td class="border p-2">
                <select name="products[0][product_id]" class="w-full border-gray-300 rounded">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{$product->name}}</option>
                    @endforeach
                <!-- <option value="2">商品 B</option> -->
                </select>
            </td>
            <td class="border p-2 text-right">
                <input type="number" name="products[0][quantities]" value="1" class="w-20 text-right border-gray-300 rounded">
            </td>
            <!-- <td class="border p-2 text-right">
                <input type="number" name="products[0][prices]" value="100" class="w-24 text-right border-gray-300 rounded">
            </td> -->
            <td class="border p-2 text-right">
                <span class="subtotal">100</span>
            </td>
            </tr>
        </tbody>
        </table>

        <a href="javascript:;" class="mb-4 text-indigo-600 hover:underline text-sm" id="addProduct">+ 新增商品</a>

        <!-- 總金額區塊 -->
        <div class="text-right text-sm mb-6">
        <div>小計：<span id="subtotal">$1000</span></div>
        <div>稅金：<span id="tax">$50</span></div>
        <div class="font-semibold">總計：<span id="total">$1050</span></div>
        </div>

        <!-- 備註與按鈕 -->
        <div class="mb-4">
        <label for="note" class="block text-sm font-medium text-gray-700">備註</label>
        <textarea id="note" name="note" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm"></textarea>
        </div>

        <div class="flex justify-end gap-2">
        <!-- <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                        bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 ">取消</button>
        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                        bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 ">儲存草稿</button> -->
        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                        bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">建立訂單</button>
        </div>
    </div>
    </form>

</x-app-layout>