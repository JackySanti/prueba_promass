<div id="cardPrincipal" class="m-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach($arreglo['productos'] as $producto)
        <div class="rounded overflow-hidden shadow-lg max-w-[15em]">
            <img class="w-full" src='{{ asset("storage/$producto->image_path")}}' alt="Sunset in the mountains">
            <div class="px-6 py-4">
                <div class="font-bold text-lg mb-2">{{$producto->barcode}} - {{$producto->name}} </div>
                    <p class="text-gray-700 text-base">Marca: {{$producto->brand}}</p>
                    <p class="text-gray-700 text-base">Cantidad: {{$producto->stock}}</p>
                    <p class="text-gray-700 text-base mb-5">Ultima actualización: {{ \Carbon\Carbon::parse($producto->updated_at)->format('d/m/Y') }}</p>
                        
                    <div class="grid grid-cols-2 place-content-center">

                    <div>
                        <button type="button" onclick="searchProduct({{$producto->id}})" class="text-white bg-[#FFC300] flex justify-center font-medium rounded-lg text-sm px-5 py-2.5 w-5/6 text-center inline-flex items-center mr-2"> Modificar </button>
                    </div>
                    
                    <div>
                       <button type="button" onclick="deleteProduct({{$producto->id}}, '{{$producto->name}}')" class="text-white bg-[#900C3F] flex justify-center font-medium rounded-lg text-sm px-5 py-2.5 w-5/6 text-center inline-flex items-center mr-2">Elimnar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>