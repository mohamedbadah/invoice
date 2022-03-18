<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\section;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = section::all();
        $products = Product::paginate(10);
        return view('products.product', ['products' => $products, 'sections' => $sections]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate(
            [
                'name_product' => 'required',
                'section_id' => 'required',
                'description' => 'required'
            ],
            [
                'name_product.required' => 'اسم المنتج مطلوب',
                'description.required' => 'يجب ان تكتب ملاحظات'
            ]
        );
        if ($validation) {
            $product = new Product();
            $product->product_name = $request->name_product;
            $product->description = $request->description;
            $product->section_id = $request->section_id;
            $isSaved = $product->save();
            $isSaved ? session()->flash('addProduct', 'لقد تمت الاضافة بنجاح') : '';
        }
        return redirect()->route('user.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator($request->all(), [
            'product_update' => 'required',
            'desc_update' => 'required'
        ]);
        if (!$validator->fails()) {
            $product->product_name = $request->product_update;
            $product->section_id = $request->section_update;
            $product->description = $request->desc_update;
            $isSaved = $product->save();
            return response()->json(['message' => $isSaved ? session()->flash('update', 'لقد تم التحديث بنجاح') :
                session()->flash('updateFaild', 'فشل في التحديث')], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(['message' => 'the update is faild'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $isDeleted = $product->delete();
        if ($isDeleted) {
            return response()->json(
                ['icon' => 'success', 'title' => 'deleted', 'text' => 'successfully deleted'],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['icon' => 'faild', 'title' => 'not deleteted', 'text' => 'faild deleted'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
