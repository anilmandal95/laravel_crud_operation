<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
class productController extends Controller
{
    //
    public function index(){

        return view('products.index',[
            'products' => product::get() 
        ]);
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){

        $request-> validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000'
        ]);
       // dd($request->all());
       $imageName = time().','.$request->image->extension();
       $request->image->move(public_path('products'),$imageName);
       //dd($imageName);

       $product = new product();
       $product->image = $imageName;
       $product->name = $request->name;
       $product->description = $request->description;


       $product->save();

       return back()->withSuccess('Product Created----!!!!');
       
    }

    public function edit($id){
        //dd($id);
        $product = product::where('id',$id)->first();
        return view('products.edit',['product' => $product]);
    }


    public function update(Request $request, $id){
      //  dd($request->all());

      $request-> validate([
        'name' => 'required',
        'description' => 'required',
        'image' => 'nullable|required|mimes:jpeg,jpg,png,gif|max:1000'
    ]);
    $product = product::where('id',$id)->first();
    if(isset($request->image)){
        $imageName = time().','.$request->image->extension();
        $request->image->move(public_path('products'),$imageName);
        $product->image = $imageName;
    }
   $product->name = $request->name;
   $product->description = $request->description;


   $product->save();

   return back()->withSuccess('Product Updated Successfully----!!!!');

    }

    public function destroy($id){
        $product = product::where('id',$id)->first();
        $product->delete();
        return back()->withSuccess('Product Deleted Successfully-----!!!!');
    }
}
