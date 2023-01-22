<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function add(Request $req){

        $data['product_name'] = $req['product_name'];
        $data['desc'] = $req['desc'];
        $data['price'] = $req['price'];
        $data['sku_code'] = uniqid();

        if($req->file('product_image')){
            $file = $req->file('product_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('images/product_images'), $filename);
            $data['image_path'] = $filename;

        }
        $res = Product::create($data);
        if($res){
            return "Product added successfully";
        }else{
            return "Product added failed";
        }
    }

    public function edit(Request $req){

        $data = Product::find($req->id);
        $data->product_name = $req['product_name'];
        $data->desc = $req['desc'];
        $data->price = $req['price'];
        $data->sku_code  = uniqid();

        if($req->file('product_image')){
            $file = $req->file('product_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('images/product_images'), $filename);
            $data->image_path = $filename;

        }
        $res = $data->save();
        if($res){
            return "Product updated successfully";
        }else{
            return "Product updated failed";
        }
    }

    public function list(Request $req){
        return Product::all();
    }
    public function delete(Request $req){

        $res = Product::find($req->id)->delete();
        if($res){
            return "Product deleted successfully";
        }else{
            return "Product deleted failed";
        }
    }
}
