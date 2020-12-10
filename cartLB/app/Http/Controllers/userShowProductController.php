<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product; 
use App\Models\Category;
Use Session;



class userShowProductController extends Controller
{
    //
    public function show(){
        
        $products=Product::paginate(10);
        
        return view('userShowProduct')->with('products',$products);
    }

   
    public function search(){
        $r=request();//retrive submited form data
        $keyword=$r->searchProduct;
        $products =DB::table('products')
        ->leftjoin('categories', 'categories.id', '=', 'products.categoryID')
        ->select('categories.name as catname','categories.id as catid','products.*')
        ->where('products.name', 'like', '%' . $keyword . '%')
        ->orWhere('products.description', 'like', '%' . $keyword . '%')
        //->get();
        ->paginate(4); 
               
        return view('userShowProduct')->with('products',$products);

    }

}