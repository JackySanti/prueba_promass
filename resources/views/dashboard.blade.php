@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promass</title>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
        
    <!-- JQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100">
    <!-- Url -->
    <input id="url" name="url" type="text" value="{{asset('')}}" hidden>


    <!-- Show -->
    <h3 class="mt-5 ml-10 text-2xl font-bold text-[#900C3F]">Stock de Productos</h3>


    <div class="py-10">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mr-2 mb-2 text-left"><strong>Filtro</strong></p>

                    <form id="filtro">
                        <div class="grid grid-cols-4 place-content-center">
                            <div>
                                <input placeholder="Código de barras" id="f_barcode" name="f_barcode" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div>
                                <input placeholder="Nombre" id="f_name" name="f_name" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div>
                                <input placeholder="Marca" id="f_brand" name="f_brand" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div>
                                <button type="button" onclick="filterProducts()" class="text-white bg-[#900C3F] flex justify-center font-medium rounded-lg text-sm px-5 py-2.5 w-full text-center inline-flex items-center mr-2">Buscar</button>
                            </div>
                        </div>
                    </form>

                    <p class="mr-2 mb-2 text-left">Total de productos: <strong>{{$arreglo['totalProductos']}}</strong>.</p>
                </div>
            </div>
        </div>
    </div>



    <div class="mr-10 text-right">
        <button id="btn_new" data-modal-target="authentication-modal" class="text-white bg-[#FFC300] flex justify-center font-medium rounded-lg text-sm px-5 py-2.5 w-64 text-center inline-flex items-center mr-2" onclick="createModal()">Nuevo Producto</button>
    </div>

    @if($arreglo['totalProductos'] > 0)
        @extends('layouts.cards')   
    @else

        <div class="py-10">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-center">No existen productos registrados...</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Add / Update Modal-->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-7xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button id="btn_authentication_modal" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="authentication-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mx-4 mb-5 font-bold text-xl text-[#900C3F] leading-tight" id="tittleModal"></h3>
                        
                    <form id="formProduct">                        
                        <div class="grid grid-cols-2 place-content-center">
                            <div>
                                <div class="text-center">
                                    <div id="upimage" class="m-5 items-center image">
                                        <div class="flex justify-center" id="imagenPrevisualizacion"></div>
                                        <br>    
                                        <p id="iconfile" class="flex justify-center pb-5 iconfile">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12">
                                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                            </svg>
                                        </p>

                                        <input class="block w-full text-sm text-gray-900 cursor-pointer bg-gray-50 dark:placeholder-gray-400" type="file" id="image">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 place-content-center">
                                <div>
                                    <label>Código de barras</label>
                                    <input id="barcode" name="barcode" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label>Nombre</label>
                                    <input id="name" name="name" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label>Marca</label>
                                    <input id="brand" name="brand" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label>Precio</label>
                                    <input id="price" name="price" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label>Unidad</label>
                                    <input id="unit" name="unit" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label>Stock</label>
                                    <input id="stock" name="stock" type="text" class="mb-5 form-controlbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-72 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label>Estado</label>
                                    <select id="status" name="status" class="mb-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="1">Habilitado</option>
                                        <option value="0">Deshabilitado</option>
                                    </select>
                                </div>

                                <div></div>

                                <div id="btnAdd">
                                    <button type="button" onclick="addProduct()" class="text-white bg-[#900C3F] flex justify-center font-medium rounded-lg text-sm px-5 py-2.5 w-64 text-center inline-flex items-center mr-2">Agregar</button>
                                </div>

                                <div id="btnUpdate" class="hidden">
                                    <input id="id" name="id" type="text" hidden>

                                    <button type="button" onclick="updateProduct()" class="text-white bg-[#900C3F] flex justify-center font-medium rounded-lg text-sm px-5 py-2.5 w-64 text-center inline-flex items-center mr-2">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div> 


    <!-- Scripts -->
    <script src="{{ asset('js/preview.js') }}"></script>
</body>
</html>