<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseController
{
    public function index(){
        $products =Product::all();
        return $this->sendResponse($products->toArray(), 'products Retrieved');
    }

    public function store(request $request){
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->senderror('Validationerror',$validator->errors());
        }
        $product =Product::create($request->all());
        return $this->sendResponse(new ProductResource($product), 'Product Created Succesfully');

    }

    public function show($id)
    
    {
        $product = Product::find($id);
        if(is_null($product)){
            return $this->senderror('Product Not found');
        }
        return $this->sendResponse(new ProductResource($product), 'Product retrieved');
    }

    public function update(Request $request, Product $product){
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->senderror('Validationerror',$validator->errors());
        }
        $product->name =$request->name;
        $product->description =$request->description;
        $product->update();
        return $this->sendResponse(new ProductResource($product)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                , 'Product updated');

    }
}
