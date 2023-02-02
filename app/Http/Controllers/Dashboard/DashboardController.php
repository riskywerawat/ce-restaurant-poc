<?php

namespace App\Http\Controllers\Dashboard;

//use App\Http\Controllers\Controller;
use App\Models\AskRequest;
use App\Models\BidRequest;
use App\Models\OrderRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use stdClass;

class DashboardController extends AuthenticatedSessionController
{
//    use AuthenticatesUsers;

//    public $redirectTo = '/dashboard';

    public function login(Request $request)
    {
        return view('dashboard.login');
    }

    public function index()
    {

        $orders = OrderRequest::
        leftJoin('kitchens','order_requests.kitchen_id', '=', 'kitchens.id')
        ->select('order_requests.id', 'kitchens.name','order_requests.status','order_requests.created_at')
        ->orderBy('id', 'DESC')
        ->orderByDesc('created_at')->take(10)->get();

        $now = new Carbon();
        $orderOneData = OrderRequest::
          leftJoin('order_items','order_requests.id', '=', 'order_items.order_request_id')
        ->leftJoin('menus','menus.id', '=', 'order_items.menu_id')
        ->leftJoin('kitchens','kitchens.id', '=', 'order_requests.kitchen_id')
        ->where('kitchen_id', '=', 1)
        ->select("kitchens.name AS kitchen","order_requests.id","order_requests.status","order_requests.kitchen_id","order_items.menu_id","menus.unit","menus.name","menus.price","order_items.quantity")
        ->get();

        $roomOneCount = OrderRequest::where('kitchen_id', '=', 1)->count();

        $orderTwoData = OrderRequest::
        leftJoin('order_items','order_requests.id', '=', 'order_items.order_request_id')
      ->leftJoin('menus','menus.id', '=', 'order_items.menu_id')
      ->leftJoin('kitchens','kitchens.id', '=', 'order_requests.kitchen_id')
      ->where('kitchen_id', '=', 2)
      ->select("kitchens.name AS kitchen","order_requests.id","order_requests.status","order_requests.kitchen_id","order_items.menu_id","menus.unit","menus.name","menus.price","order_items.quantity")
      ->get();
      $roomTwoCount = OrderRequest::where('kitchen_id', '=', 2)
        ->count();

        $orderThreeData = OrderRequest::
        leftJoin('order_items','order_requests.id', '=', 'order_items.order_request_id')
      ->leftJoin('menus','menus.id', '=', 'order_items.menu_id')
      ->leftJoin('kitchens','kitchens.id', '=', 'order_requests.kitchen_id')
      ->where('kitchen_id', '=', 3)
      ->select("kitchens.name AS kitchen","order_requests.id","order_requests.status","order_requests.kitchen_id","order_items.menu_id","menus.unit","menus.name","menus.price","order_items.quantity")
      ->get();
      $roomThreeCount = OrderRequest::where('kitchen_id', '=', 3)
        ->count();

        $data = [];

        $data = [[
            "order"=>$orderOneData,
            "count"=>$roomOneCount
        ],
        [
            "order"=>$orderTwoData,
            "count"=>$roomTwoCount
        ],
        [
            "order"=>$orderThreeData,
            "count"=>$roomThreeCount
        ]
    ];

        return view('dashboard.index', compact('orders','data' ));
    }

    public function logout(Request $request)
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect()->route('dashboard.login');
    }
}
