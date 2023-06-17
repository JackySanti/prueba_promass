<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;

class ProductsController extends Controller
{
    public function show(){
        try {
            Carbon::setUTF8(true);
            Carbon::setLocale(config('app.locale'));
            setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
            
            $fechaActual = Carbon::now();
            $mesActual = $fechaActual->formatLocalized('%B'); 
            $anoActual = $fechaActual->format('Y');

            $totalProductos = Products::count();
            $productos = Products::all();

            $arreglo = [
                "fecha"           => "Indicadores ".ucfirst($mesActual)." ".$anoActual,
                "totalProductos"  => $totalProductos,
                "productos"       => $productos,
            ];

            return view('dashboard')->with('arreglo', $arreglo);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filterProducts(Request $request){
        try {
            $conditions = [];

            if($request->f_barcode) array_push($conditions, ['barcode','LIKE',"%{$request->f_barcode}%"]);
            if($request->f_name)    array_push($conditions, ['name','LIKE',"%{$request->f_name}%"]);
            if($request->f_brand)   array_push($conditions, ['brand','LIKE',"%{$request->f_brand}%"]);

            if(count($conditions) > 0) $product = Products::where($conditions)->get();  
            else $productos = Products::all();

            var_dump($product);
            return array(  
                'error'   => false, 
                'message' => '', 
                'result'  => $product,
                'code'    => 200
            );

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function searchProduct(Request $request){
        try {
            $product = Products::find($request->id);

            return array(  
                'error'   => false, 
                'message' => '', 
                'result'  => $product,
                'code'    => 200
            );

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function store(Request $request){
        try {
            if($request->hasFile('image')){
                $imgPath = $request->file('image')->store('public/post');
                
                $arreglo = explode('/',$imgPath);
                array_shift($arreglo);
                $ruta = implode('/', $arreglo);

                $product = new Products;

                $product->barcode    =  $request->barcode;
                $product->name       =  $request->name;
                $product->brand      =  $request->brand;
                $product->price      =  $request->price;
                $product->unit       =  $request->unit;
                $product->stock      =  $request->stock;
                $product->image_path =  $ruta;
                $product->status     =  $request->status;
                $product->created_at   =  date("d-m-Y h:i:s");
                $product->updated_at =  date("d-m-Y h:i:s");

                $product->save();

                return array(  
                    'error'   => false, 
                    'message' => 'Se almacenó el producto correctamente.', 
                    'code'    => 200
                );
            } else {
                return array(  
                    'error'   => true, 
                    'message' => 'No se encontro la imagen.', 
                    'code'    => 200
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request){
        try {
            if($request->hasFile('image')){
                $imgPath = $request->file('image')->store('public/post');
                
                $arreglo = explode('/',$imgPath);
                array_shift($arreglo);
                $ruta = implode('/', $arreglo);

                $product = Products::find($request->id);

                $product->barcode    =  $request->barcode;
                $product->name       =  $request->name;
                $product->brand      =  $request->brand;
                $product->price      =  $request->price;
                $product->unit       =  $request->unit;
                $product->stock      =  $request->stock;
                $product->image_path =  $ruta;
                $product->status     =  $request->status;
                $product->updated_at =  date("d-m-Y h:i:s");

                $product->save();

                return array(  
                    'error'   => false, 
                    'message' => 'Se actualizó el producto correctamente.', 
                    'code'    => 200
                );

            } else {
                $product = Products::find($request->id);

                $product->barcode    =  $request->barcode;
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
            }

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