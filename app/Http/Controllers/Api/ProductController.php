<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy("id","desc")->get();

        if($products->isEmpty()){
            return response()->json([
                "status"=> "success",
                "message"=> "No record available."
                ], 200);
        }else{
            return ProductResource::collection($products);
        }
    }

    public function store(Request $request){
        $request->validate([
            "name"=> ["required","string"],
            "price"=> ["required"],
            "description"=> ["required","string"],
        ]);

        $product = Product::create([
            "name"=> $request["name"],
            "price"=> $request["price"],
            "description"=> $request["description"],
        ]);

        return response()->json([
            "status"=> "success",
            "message"=> "Successfuly created!",
            "data"=>new ProductResource($product), 
        ], 201);
    }

    public function show(Product $product){
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product){
        $request->validate([
            "name"=> ["required","string"],
            "price"=> ["required"],
            "description"=> ["required","string"],
        ]);

        $product->update([
            "name"=> $request["name"],
            "price"=> $request["price"],
            "description"=> $request["description"],
        ]);

        return response()->json([
            "status"=> "success",
            "message"=> "Successfuly updated!",
            "data"=>new ProductResource($product), 
        ], 201);
    }

    public function destroy(Product $product){
      $product->delete();
      return response()->json([
        "status"=> "success",
        "message"=> "Deleted!"
      ], 200);

    }
}
