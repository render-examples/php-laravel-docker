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

class StockMovementController extends Controller
{
    public function list(){
        return view('stockMovement.index', []);
    }
}
