@section('jshead')
    <!-- <style>
        * {
        box-sizing: border-box;
        }

        body {
        margin: 0;
        font-family: Arial, "Microsoft JhengHei", sans-serif;
        background: #f3f5f8;
        color: #1f2937;
        }

        .page {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 24px;
        }

        .page-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        }

        .page-desc {
        color: #6b7280;
        margin-bottom: 24px;
        }

        .card {
        background: #fff;
        border: 1px solid #d9dee7;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,.04);
        overflow: hidden;
        }

        .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fbff;
        }

        .breadcrumb {
        font-weight: 600;
        color: #374151;
        }

        .btn-primary {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 10px 16px;
        font-weight: 600;
        cursor: pointer;
        }

        .btn-secondary {
        background: #e5e7eb;
        color: #374151;
        border: none;
        border-radius: 6px;
        padding: 10px 16px;
        cursor: pointer;
        }

        .filters {
        display: grid;
        grid-template-columns: 1.3fr 1fr 1fr 1.8fr auto auto;
        gap: 16px;
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
        align-items: end;
        }

        .form-group label {
        display: block;
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 8px;
        }

        input,
        select {
        width: 100%;
        height: 38px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 0 12px;
        font-size: 14px;
        background: #fff;
        }

        .date-range {
        display: flex;
        align-items: center;
        gap: 8px;
        }

        .table-area {
        padding: 24px;
        }

        .table-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
        align-items: center;
        }

        .entries select {
        width: 70px;
        margin-right: 6px;
        }

        .search {
        display: flex;
        align-items: center;
        gap: 8px;
        }

        .search input {
        width: 220px;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        }

        th {
        text-align: left;
        padding: 12px 10px;
        border-bottom: 1px solid #9ca3af;
        font-size: 14px;
        color: #374151;
        }

        td {
        padding: 12px 10px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 15px;
        }

        tr:hover {
        background: #f9fafb;
        }

        .amount {
        text-align: right;
        }

        .status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        }

        .status-pending {
        color: #dc2626;
        background: #fee2e2;
        border: 1px solid #fecaca;
        }

        .status-approved {
        color: #15803d;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
        }

        .status-shipped {
        color: #2563eb;
        background: #dbeafe;
        border: 1px solid #bfdbfe;
        }

        .btn-detail {
        background: #6366f1;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 7px 12px;
        cursor: pointer;
        font-size: 14px;
        }

        .summary-row td {
        border-bottom: 1px solid #9ca3af;
        font-weight: 700;
        }

        .total-label {
        text-align: right;
        }

        .total-money {
        font-weight: 700;
        text-align: right;
        }

        .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 18px;
        color: #374151;
        }

        .pagination {
        display: flex;
        gap: 8px;
        align-items: center;
        }

        .page-btn {
        border: 1px solid #d1d5db;
        background: #fff;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        }

        .page-btn.active {
        background: #f3f4f6;
        border-color: #9ca3af;
        font-weight: 700;
        }

        .status-help {
        margin-top: 28px;
        padding: 20px 24px;
        background: #f8fbff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        }

        .status-help h3 {
        margin-top: 0;
        margin-bottom: 16px;
        color: #1d4ed8;
        }

        .status-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        }

        .status-box {
        font-size: 14px;
        line-height: 1.7;
        color: #4b5563;
        }

        .status-box strong {
        display: block;
        margin-bottom: 6px;
        color: #111827;
        }

        @media (max-width: 900px) {
        .filters {
            grid-template-columns: 1fr 1fr;
        }

        .status-grid {
            grid-template-columns: 1fr 1fr;
        }

        .table-area {
            overflow-x: auto;
        }

        table {
            min-width: 900px;
        }
        }

        @media (max-width: 600px) {
        .filters {
            grid-template-columns: 1fr;
        }

        .table-top,
        .table-footer,
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .status-grid {
            grid-template-columns: 1fr;
        }
        }
    </style> -->
    <style>
    body {
        margin: 0;
        font-family: Arial, "Microsoft JhengHei", sans-serif;
        background: #f3f6fb;
        color: #1f2d3d;
    }

    .page {
        width: 1180px;
        margin: 50px auto;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .desc {
        color: #6b7280;
        margin-bottom: 25px;
    }

    .card {
        background: #fff;
        border: 1px solid #d9e2ef;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 22px 26px;
        border-bottom: 1px solid #e5e7eb;
        font-weight: bold;
    }

    .btn-primary {
        background: #315be8;
        color: white;
        border: none;
        padding: 12px 22px;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .filters {
        display: flex;
        gap: 18px;
        padding: 24px 26px;
        border-bottom: 1px solid #e5e7eb;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    label {
        font-size: 14px;
        color: #4b5563;
    }

    select,
    input {
        height: 38px;
        border: 1px solid #cfd8e3;
        border-radius: 6px;
        padding: 0 12px;
        min-width: 150px;
    }

    .search-input {
        min-width: 280px;
    }

    .btn-search {
        background: #315be8;
        color: white;
        border: none;
        height: 38px;
        padding: 0 20px;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-reset {
        background: #e5e7eb;
        color: #374151;
        border: none;
        height: 38px;
        padding: 0 20px;
        border-radius: 6px;
        cursor: pointer;
    }

    .table-area {
        padding: 24px 26px;
    }

    .table-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th {
        text-align: left;
        padding: 14px 10px;
        border-bottom: 1px solid #9ca3af;
    }

    td {
        padding: 14px 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: bold;
    }

    .ok {
        background: #d1fae5;
        color: #059669;
    }

    .low {
        background: #fef3c7;
        color: #d97706;
    }

    .empty {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-detail {
        background: #6366f1;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 5px;
        cursor: pointer;
    }

    .summary-row td {
        font-weight: bold;
        border-top: 1px solid #9ca3af;
    }

    .footer {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .pagination button {
        border: 1px solid #cfd8e3;
        background: white;
        padding: 8px 12px;
        border-radius: 4px;
        margin-left: 4px;
    }
    </style>
    <script>

        // 監聽月份變更
        $('#month').on('change', function() {
            month = this.value;
            fetchSalesByProductData(month);
        });

        function fetchStockRange(){

        }
    </script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('庫存管理列表') }}
            <div class="desc">這個頁面是讓使用者查看、搜尋、管理所有產品的庫存狀態，以及查看庫存異動紀錄。</div>
        </h2>
    </x-slot>
    

    <section class="card">

        <div class="card">
            <div class="card-header">
                <div class="breadcrumb">📦 庫存管理 / 庫存列表</div>
                <button class="btn-primary">＋ 新增庫存異動</button>
            </div>

            <div class="filters">
                <div class="filter-group">
                    <label>商品分類</label>
                    <select>
                        <option>全部</option>
                        <option>電腦設備</option>
                        <option>工業設備</option>
                        <option>耗材</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>庫存狀態</label>
                    <select>
                        <option>全部</option>
                        <option>庫存充足</option>
                        <option>庫存偏低</option>
                        <option>庫存不足</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>庫存數量</label>
                    <input type="number" placeholder="最小量">
                </div>

                <div class="filter-group">
                    <label>&nbsp;</label>
                    <input type="number" placeholder="最大量">
                </div>

                <div class="filter-group">
                    <label>搜尋</label>
                    <input class="search-input" type="text" placeholder="商品編號 / 名稱 / 條碼">
                </div>

                <button class="btn-primary" onclick="fetchStockRange()">搜尋</button>
                <button class="btn-secondary">重設</button>
            </div>

            <div class="table-area">
                <div class="table-top">
                    <div>
                        <select>
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                        entries per page
                    </div>
                    <div>
                        Search:
                        <input type="text">
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>商品編號</th>
                            <th>商品名稱</th>
                            <th>分類</th>
                            <th>單位</th>
                            <th>庫存數量</th>
                            <th>安全庫存</th>
                            <th>狀態</th>
                            <th>最近異動時間</th>
                            <th>操作</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>P00001</td>
                            <td>P202509001</td>
                            <td>筆記型電腦</td>
                            <td>電腦設備</td>
                            <td>台</td>
                            <td>25</td>
                            <td>10</td>
                            <td><span class="badge ok">庫存充足</span></td>
                            <td>2025-09-24 10:15:32</td>
                            <td><button class="btn-detail">查看異動</button></td>
                        </tr>

                        <tr>
                            <td>P00002</td>
                            <td>P202509002</td>
                            <td>PLC 控制器</td>
                            <td>工業設備</td>
                            <td>台</td>
                            <td>3</td>
                            <td>10</td>
                            <td><span class="badge low">庫存偏低</span></td>
                            <td>2025-09-24 09:02:18</td>
                            <td><button class="btn-detail">查看異動</button></td>
                        </tr>

                        <tr>
                            <td>P00003</td>
                            <td>P202509003</td>
                            <td>24吋液晶螢幕</td>
                            <td>顯示設備</td>
                            <td>台</td>
                            <td>0</td>
                            <td>5</td>
                            <td><span class="badge empty">庫存不足</span></td>
                            <td>2025-09-23 16:45:21</td>
                            <td><button class="btn-detail">查看異動</button></td>
                        </tr>

                        <tr>
                            <td>P00004</td>
                            <td>P202509004</td>
                            <td>A4 影印紙</td>
                            <td>耗材</td>
                            <td>包</td>
                            <td>150</td>
                            <td>20</td>
                            <td><span class="badge ok">庫存充足</span></td>
                            <td>2025-09-22 14:33:45</td>
                            <td><button class="btn-detail">查看異動</button></td>
                        </tr>

                        <tr class="summary-row">
                            <td colspan="3">合計庫存項目</td>
                            <td colspan="3">4 項商品</td>
                            <td colspan="2">總庫存數量</td>
                            <td colspan="2">178</td>
                        </tr>
                    </tbody>
                </table>

                <div class="footer">
                    <div>Showing 1 to 4 of 4 entries</div>
                    <div class="pagination">
                        <button>«</button>
                        <button>‹</button>
                        <button>1</button>
                        <button>›</button>
                        <button>»</button>
                    </div>
                </div>
            </div>
        </div>

    </setion>

</x-app-layout>