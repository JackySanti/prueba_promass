<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;

class ProductsController extends Controller
{
    public function show(Request $request){
        try {
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function store(Request $request){
        try {
            $product = new Products;

            $product->barcode    =  $request->barcode;
            $product->name       =  $request->name;
            $product->brand      =  $request->brand;
            $product->price      =  $request->price;
            $product->unit       =  $request->unit;
            $product->stock      =  $request->stock;
            $product->status     =  $request->status;
            $pages->created_at   =  date("d-m-Y h:i:s");
            $product->updated_at =  date("d-m-Y h:i:s");

            $product->save();

            return array(  
                'error'   => false, 
                'message' => 'Se almacenó el producto correctamente.', 
                'code'    => 200
            );

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request){
        try {
            $product = Products::find($request->id);

            $product->name       =  $request->name;
            $product->brand      =  $request->brand;
            $product->price      =  $request->price;
            $product->unit       =  $request->unit;
            $product->stock      =  $request->stock;
            $product->status     =  $request->status;
            $product->updated_at =  date("d-m-Y h:i:s");

            $product->save();

            return array(  
                'error'   => false, 
                'message' => 'Se actualizó el producto correctamente.', 
                'code'    => 200
            );

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function destroy(Request $request){
        try {
            $product = Products::find($request->id);
            $product->delete();

            return array(  
                'error'   => false, 
                'message' => 'Se eliminó el producto correctamente.', 
                'code'    => 200
            );

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
