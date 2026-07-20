<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\Auth;
use Log;

class OrderController extends Controller
{
    function list()
    {
        $result = Order::All();
        foreach($result as $order){
            $order->order_number = 'O'. $order->order_number;
            $statusList = [0=> '未審核', 1=> '審核通過', 2=> '審核不通過'];
            $order->statusWord = $statusList[$order->status];
        }
        // dd('ggg');
        // 如果是主管要能看到省批的按鈕
        $roles = Auth::user()->roles;
        $permissions = $roles->flatMap(function ($role) {
            return $role->permissions;
        })->unique('id');
        // dd($roles, $permissions);

        $canApprove = false;
        if($permissions->contains('name', 'approve_order')){
            $canApprove = true;
        }

        return view('order.index', ['orders' => $result, 'canApprove' => $canApprove]);
    }

    function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        // dd($products);
        $productjs = [];
        foreach($products as $product){
            $productjs[$product->id] = $product;
        }
        // dd($productjs, json_encode($productjs));
        return view('order.new', [
                                    'products' => $products,
                                    'customers' => $customers,
                                    'productjs' => $productjs,
                                ]);
    }
    
    function store(StoreOrderRequest $request)
    {
        try{
            // 驗證
            $validated = $request->validated();
            $lastOrder = Order::latest()->first();

            $orderNumber = 134500001;
            if(isset($lastOrder)){
                $orderNumber = $lastOrder->order_number + 1;
                // $orderNumber = 'O' . $number;
            }
            
            // 建立order and order_item
            $query = DB::transaction(function () use ($request, $orderNumber) {
                // dd($request,$request->products , $orderNumber);
                // 建立訂單
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'customer_id' => $request->customer,
                ]);
                if (!$order) throw new \Exception('建立訂單失敗');
                
                // 建立訂單品項
                $orderItemsData = [];
                foreach($request->products as $products){
                    $orderItemsData[] = [
                        'product_id' => $products['product_id'],
                        'order_id' => $order->id,
                        'amount' => $products['quantities'],
                        'created_at' => now(),  // insert() 不會自動補 timestamps
                        'updated_at' => now(),
                    ];
                }
                if(count($orderItemsData) == 0) throw new \Exception('品項不得為0');
                if (!OrderItem::insert($orderItemsData)) {
                    throw new \Exception('建立訂單品項失敗');
                }

                return true;
            }); 

            if($query){
                // 存入
                return redirect('order/index');
            } else {
                return redirect('order/create')
                        ->withErrors(['msg' => '建立訂單失敗'])
                        ->withInput();
            }

        } catch (ValidationException $exception) {
        return redirect('order/create')
            ->withErrors($exception->validator)
            ->withInput();
        } 
        // catch (\Exception $e) {
        //     return redirect('order/create')
        //         ->withErrors(['msg' => $e->getMessage()])
        //         ->withInput();
        // }
    }

    function show(Request $request){
        // dd($id);
        dd($request->input('orderId'));

        
        $order = Order::with('customer')->findOrFail($id);
        $customer = $order->customer;
        $orderItems = OrderItem::with('product')->where('order_id', $id)->get();
        return view('order.show', [
                                    'order' => $order,
                                    'customer' => $customer,
                                    'orderItems' => $orderItems,
                                ]);
    }

    function appoveOrder(Request $request, $id){
        Log::info($request->input('approved'));
        $approved = $request->input('approved') ? 1 : 2;
        $orderId = (int)$request->input('orderId');
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
        }
        
        if($approved !== 1){
            $order->status = $approved; // 1: approved, 2: rejected
            $order->save();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Order rejected'
                ]);
        }
        
        $outOfStockProducts = [];
        $stockParams = [];
        $user = Auth::user();
Log::info(1);
        DB::beginTransaction();
Log::info(1.4);
        // try {
Log::info(1.41);
            $orderItems = OrderItem::where('order_id', $orderId)->get();
Log::info(json_encode($orderItems));
            foreach($orderItems as $key => $value){
Log::info(1.5);
                $product = Product::where('id', $value->product_id)->first();
Log::info(json_encode($product));

                // 檢查庫存不足
                if($product->amount < $value->amount){
                    array_push($outOfStockProducts, $product->name);
                    continue;
                }
                // 扣庫存
                $product->decrement('amount', $value->amount);

                // 新增庫存異動紀錄
                $stockParams[] = [
                    'product_id' => $product->id,
                    'order_id'   => $order->id,
                    'user_id'    => $user->id,
                    'type'       => 3, // 出庫
                    'balance'    => $product->amount,
                    'quantity'   => $value->amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
Log::info(2);
            }

            // 有缺貨，rollback
            if (!empty($outOfStockProducts)) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => '產品 ' . implode(',', $outOfStockProducts) . ' 庫存不足'
                ]);
            }

Log::info(3);

            // 批量新增 stock_movements
            StockMovement::insert($stockParams);

            // 訂單通過
            $order->status = $approved; // approved
            $order->save();

Log::info(4);
            DB::commit();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Order approved successfully'
                ]);

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => '審核失敗: ' . $e->getMessage()
        //     ], 500);
        // }
    }
}
