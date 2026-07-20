<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function orders()
    {
        $orders = Order::with('orderItems.product')->get();
        $totalMoney = 0;
        foreach($orders as $order){
            $order->order_number = 'O'. $order->order_number;
            $order->customer_name = $order->customer->name; // 取得關聯的客戶名稱
            $statusList = [0=> '未審核', 1=> '審核通過', 2=> '審核不通過', 3=> '已出貨'];
            $statusStyle = [0=> 'red', 1=> 'green', 2=> 'DarkGray', 3=> 'green'];
            $order->statusWord = $statusList[$order->status];
            $order->statusStyle = $statusStyle[$order->status];
            foreach($order->orderItems as $item){
                $totalMoney += (int)$item->amount *(int)$item->price;
                $order->price += (int)$item->amount *(int)$item->price;
            }
            // dd($order, $totalMoney);
        }
        return view('reports.orders', [
                                        'orders' => $orders,
                                        'totalMoney' => $totalMoney
                                    ]);
    }

    public function salesByProduct(Request $request)
    {
        $month = $request->input('month', '');
        Logger()->info('查詢月份', ['month' => $month]);

         // 驗證月份格式 (YYYY-MM)
        if (empty($month)) {
            return response()->json(['error' => '月份參數缺失'], 500);
        }
        
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $orders = Order::whereBetween('created_at', [$start, $end])->get();

        // 抓到分類的產品總數
        $sales = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select('products.id', 'products.name', 'products.price', DB::raw('SUM(order_items.amount) as total_sold'))
            ->groupBy('products.id')
            ->get();
        
        return response()->json($sales);
    }
}
