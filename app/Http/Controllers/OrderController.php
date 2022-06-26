<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Validator;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $orders=Order::with("variant")->orderBy("id","DESC");
        if($request->get('filter')){
            $filter=json_decode($request->get("filter"));
            if(isset($filter->variant_id)){
                $orders=$orders->where('variant_id',$filter->variant_id);
            }
        }
        // if($request->get("range")){
        //     $range=json_decode($request->get("range"));
        //     $orders=$orders->offset($range[0])->limit($range[1]-$range[0]+1);
        // }
        return OrderResource::collection($orders->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $input['customer']=json_encode($input['customer']);

        $validator = Validator::make($input, [
            'customer' => 'required|json',
            'variant_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = Order::create($input);
        return new OrderResource($order);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    //     $order = Order::find($id);
    //     if (is_null($order)) {
    //         return $this->sendError('Category not found.');
    //     }
    //     return $order;
    //     // return new OrderResource($order);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Order $order)
    // {
    //     //
    //     $input = $request->all();
    //     $validator = Validator::make($input, [
    //         'name' => 'required|unique:products,name,'.$order->id,
    //     ]);

    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());
    //     }

    //     $order->name=$input['name'];
    //     $order->save();

    //     return $order;
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Order $order)
    // {
    //     //
    //     $order->delete();
    //     return $order;
    // }
}
