<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\OrderRequest;
use App\Http\Requests\StoreOrderRequestRequest;
use App\Http\Requests\UpdateOrderRequestRequest;
use App\Models\Kitchen;
use App\Models\Transaction;

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
        ->select('order_requests.id', 'kitchens.name', 'order_requests.order_time','order_requests.status')
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
        $orders = OrderRequest::
        leftJoin('kitchens','order_requests.kitchen_id', '=', 'kitchens.id')
        ->select('order_requests.id', 'kitchens.name', 'order_requests.order_time','order_requests.status')
        ->get();
        return view('dashboard.order_request.create',compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function show(OrderRequest $orderRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderRequest $orderRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequestRequest  $request
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequestRequest $request, OrderRequest $orderRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderRequest  $orderRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderRequest $orderRequest)
    {
        //
    }
}
