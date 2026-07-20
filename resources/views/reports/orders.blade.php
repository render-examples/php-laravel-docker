@section('jshead')
    <script>
        
        // 條列式
        new DataTable('#example');
        let salesChart = null;
        // renderSalesByProductChart();
        let month = new Date().toISOString().slice(0, 7); // 例如 "2025-10"
        // let month = '2025-09';
        fetchSalesByProductData(month);

        // 取得訂單細項
        function getOrderContent(orderId){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                url: "{{ route('order.detail', ['id' => ':id']) }}".replace(':id', orderId),
                type: 'POST',
                dataType: 'json',
                data: {
                    orderId: Number(orderId)
                },
                success: function(response) {
                    console.log(response);
                    console.log(response.data);

                    // alert('訂單已通過');
                    if(response.status == 'success'){

                        let tableBody = '';
                        for(const item of response.data.order_items){        
                            console.log(item);
                            $count = item.amount * item.price;
                            tableBody +=`
                            <tr>
                                <td>${item.product.name}</td>
                                <td>${item.amount}</td>
                                <td>${item.product.amount}</td>
                                <td>${item.price}</td>
                                <td>${$count}<td>
                            </tr>`;
                        }

                        Swal.fire({
                            title: "訂單細項",
                            html: `
                                <div style="max-height: 400px; overflow-y: auto;">
                                    <table style="
                                        width: 100%;
                                        border-collapse: collapse;
                                        text-align: center;
                                        font-size: 14px;
                                    ">
                                        <thead style="background-color: #f8f9fa;">
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px;">產品名稱</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">訂單數量</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">現有庫存</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">單價</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">小計</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${tableBody}
                                        </tbody>
                                    </table>
                                </div>
                            `,
                            cancelButtonAriaLabel: "Thumbs down"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                    alert('訂單出貨失敗');
                }
            });
        }

        // 各產品銷售比例資料
        function fetchSalesByProductData(month) {
            return $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: "{{ route('report.salesByProduct') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    month: month
                },
                success: function(response) {
                    // JSON.parse(response);
                    console.log(response);
                    renderSalesByProductChart(response);
                    $('#month').val(month);
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                    // alert('無法取得各產品銷售比例資料');
                }
            });
        }

        // 各產品銷售比例圓餅圖
        function renderSalesByProductChart(data) {
            console.log(data);
            const ctx = document.getElementById('salesByProductChart').getContext('2d');
            if (salesChart) {
                salesChart.destroy();
            }
            const labels = data.map(item => item.name);
            const salesData = data.map(item => Number(item.total_sold));
            console.log('salesData', salesData)
            salesChart = new Chart(ctx, {
                type: 'pie',
                options: {
                    responsive: false,        // 關鍵！關閉自動調整
                    maintainAspectRatio: false, // 保持寬高比可用
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            color: '#fff',
                            formatter: (value, context) => {
                                // 計算百分比
                                const sum = salesData.reduce((a, b) => a + b, 0);
                                const percentage = ((value / sum) * 100).toFixed(1) + '%';
                                return percentage;
                            },
                        },
                    },
                },
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales by Product',
                        data: salesData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                plugins: [ChartDataLabels]
            });
        }

        // 監聽月份變更
        $('#month').on('change', function() {
            month = this.value;
            fetchSalesByProductData(month);
        });
    </script>
    <style>
        table.dataTable {
            background-color: #fff !important;
        }
        
    </style>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('產品列表') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6">

            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>customer name</th>
                        <th>status</th>
                        <th>price</th>
                        <th>created_at</th>
                        <th>細項</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td style="color: {{ $order->statusStyle }};">{{ $order->statusWord }}</td>
                        <td>{{ $order->price }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <button class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 " href="javascript:void(0)"
                             onclick="getOrderContent('{!! $order->id !!}')">訂單細項</button>
                             <!-- :href="route('order.show', ['id' => $order->id])" -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>total Money</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>${{ $totalMoney }}</th>
                    </tr>
                </tfoot>
            </table>


            <div class="container">
            <h3>📊 各產品銷售比例</h3>

            <label for="month">選擇月份：</label>
            <input type="month" id="month" name="month" value="{{ now()->format('Y-m') }}">

            <canvas id="salesByProductChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

</x-app-layout>