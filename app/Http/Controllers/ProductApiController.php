<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $product = product::paginate(10);

        $product = Product::with('comment')->first();
        if ($product==null){
            return "Empty array!.";
        }
        dd($product->toArray());

        return ProductResource::collection($product);
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
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'price'=>'required',
            'description' => 'required',
        ]);

        $path = $request->file('image')->store('public/images');

        $product = new Product();

        $product->name = $request->name;
        $product->price = $request->price;
        $product->image = $path;
        $product->description = $request->description;

        if($product->save())
        {
            return new ProductResource($product);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        //$product = Product::with('comment')->first();
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'price'=>'required',
            'description' => 'required',
        ]);

        $product = Product::find($id);

        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $path = $request->file('image')->store('public/images');
            $product->image = $path;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if($product->save())
        {
            return new ProductResource($product);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->delete())
        {
            return new ProductResource($product);
        }
    }
}
