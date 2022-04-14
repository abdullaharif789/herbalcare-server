<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variant;
use Validator;

class VariantController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $variants=Variant::with("product")->orderBy("id","DESC");
        if($request->get('filter')){
            $filter=json_decode($request->get("filter"));
            if(isset($filter->product_id)){
                $variants=$variants->where('product_id',$filter->product_id);
            }
        }
        if($request->get("range")){
            $range=json_decode($request->get("range"));
            $variants=$variants->offset($range[0])->limit($range[1]-$range[0]+1);
        }
        return $variants->get();
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
        $validator = Validator::make($input, [
            'product_id' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $variant = Variant::create($input);
        return $variant;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $variant = Variant::find($id);
        if (is_null($variant)) {
            return $this->sendError('Category not found.');
        }
        return $variant;
        // return new VariantResource($variant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variant $variant)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $variant->product_id=$input['product_id'];
        $variant->price=$input['price'];
        $variant->save();

        return $variant;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variant $variant)
    {
        //
        $variant->delete();
        return $variant;
    }
}
