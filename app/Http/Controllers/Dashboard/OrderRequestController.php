<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\OrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequestRequest;
use App\Models\Kitchen;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = OrderRequest::
        leftJoin('kitchens','order_requests.kitchen_id', '=', 'kitchens.id')
        ->select('order_requests.id', 'kitchens.name','order_requests.status','order_requests.created_at')
        ->orderBy('id', 'DESC')
        ->get();

        return view('dashboard.order_request.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orders = new OrderRequest();
        $orderItems = new OrderItem();
        $dropdownListKitchen = Kitchen::all();
        $dropdownListKitchen = collect($dropdownListKitchen)->map(function ($name) {
            return [
               "code"=>$name['id'],
               "name"=>$name['name'],
            ];
        })->reject(function ($name) {
            return empty($name);
        });
        $dropdownMenus = Menu::all();
        $dropdownMenus = collect($dropdownMenus)->map(function ($name) {
            return [
               "code"=>$name['id'],
               "name"=>$name['name']." : ".$name['price']." ".$name['unit'],
            ];
        })->reject(function ($name) {
            return empty($name);
        });


        return view('dashboard.order_request.create',compact('orders','orderItems','dropdownListKitchen','dropdownMenus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
     try {
        $createOrder = new OrderRequest();
        $createOrder->kitchen_id = $request->kitchen;
        $createOrder->save();

        error_log($createOrder);

        $orderItems = new OrderItem();
        $orderItems->order_request_id = $createOrder->id;
        $orderItems->menu_id = $request->menus;
        $orderItems->quantity = $request->quantity;
        $orderItems->save();

        DB::commit();
        return redirect()->route('dashboard.order_request.index')->with('success', 'สร้างรายการเรียบร้อย');
     } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
     }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function show(OrderRequest $orders,$key)
    {
        $orders = OrderRequest::
        leftJoin('order_items','order_requests.id', '=', 'order_items.order_request_id')
        ->leftJoin('menus','menus.id', '=', 'order_items.menu_id')
        ->leftJoin('kitchens','kitchens.id', '=', 'order_requests.kitchen_id')
        ->where('order_requests.id',"=",$key)
        ->select("kitchens.name AS kitchen","order_requests.id","order_requests.status","order_requests.kitchen_id","order_items.menu_id","menus.unit","menus.name","menus.price","order_items.quantity")
        ->first();
        $orders->total =  $orders->price *  $orders->quantity;
        return view('dashboard.order_request.show', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $key)
    {

        $orders = OrderRequest::
        leftJoin('kitchens','order_requests.kitchen_id', '=', 'kitchens.id')
        ->select('order_requests.id', 'kitchens.name','order_requests.status')
        ->orderBy('id', 'DESC')
        ->get();
        $dropdownListKitchen = Kitchen::all();
        $dropdownListKitchen = collect($dropdownListKitchen)->map(function ($name) {
            return [
               "code"=>$name['id'],
               "name"=>$name['name'],
            ];
        })->reject(function ($name) {
            return empty($name);
        });
        $dropdownMenus = Menu::all();
        $dropdownMenus = collect($dropdownMenus)->map(function ($name) {
            return [
                "code"=>$name['id'],
                "name"=>$name['name']." : ".$name['price']." ".$name['unit'],
            ];
        })->reject(function ($name) {
            return empty($name);
        });

        error_log($orders);

         $orders = OrderRequest::

         leftJoin('order_items','order_requests.id', '=', 'order_items.order_request_id')

        ->where('order_requests.id',"=",$key)
        ->select("order_requests.id","order_requests.kitchen_id","order_items.menu_id","order_items.quantity")
        ->first();


        $dropdownListKitchen = Kitchen::all();
        $dropdownListKitchen = collect($dropdownListKitchen)->map(function ($name) {
            return [
               "code"=>$name['id'],
               "name"=>$name['name'],
            ];
        })->reject(function ($name) {
            return empty($name);
        });
        $dropdownMenus = Menu::all();
        $dropdownMenus = collect($dropdownMenus)->map(function ($name) {
            return [
               "code"=>$name['id'],
               "name"=>$name['name']." : ".$name['price']." ".$name['unit'],
            ];
        })->reject(function ($name) {
            return empty($name);
        });

        return view('dashboard.order_request.edit',compact('orders','dropdownListKitchen','dropdownMenus'));

        //  return view('dashboard.order_request.edit',compact('orders'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequestRequest  $request
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequestRequest $request, OrderRequest $orderRequest,$key)
    {

        OrderRequest::where('id', $key)
        ->update([
            'kitchen_id' => $request->kitchen
         ]);

         OrderItem::where('order_request_id', $key)
         ->update([
             'menu_id' => $request->menus,
             'quantity' => $request->quantity
          ]);

        // $orderItems = OrderItem::
        // where('order_request_id', '=' , $order->id);
        // $orderItems->menu_id = $request->menu_id;
        // $orderItems->save();


     return redirect()->route('dashboard.order_request.index')->with('success', 'แก้ไขรายการเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderRequest $orderRequest,$key)
    {
        $orders = OrderRequest::where("id","=",$key);
        $orders->delete();

        return redirect()->route('dashboard.order_request.index')->with('success', 'ลบรายการผู้ใช้เรียบร้อย');
    }
}
