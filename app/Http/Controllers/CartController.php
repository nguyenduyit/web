<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    //
    public function save_cart(Request $request){
        $bookID=$request->book_hidden;
        $quantity=$request->qty;
        $book_info=DB::table('tbl_book')->where('book_id',$bookID)->first();
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $quantity_book=$book_info->book_quantity;
        if($quantity <=$quantity_book ){
            $data['id']=$book_info->book_id;
            $data['qty']=$quantity;
            $data['name']=$book_info->book_name;
            $data['price']=$book_info->book_price;
            $data['weight']='0';
            $data['options']['image']=$book_info->book_image;
            Cart::add($data);
            return Redirect::to('/show-cart');
        }   
        else{
            Session::put('message','Số lượng bạn đặt nhiều hơn số lượng trong kho');
            return Redirect::to('/chi-tiet-sach/'.$bookID);
        }     
    }
    public function show_cart(){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        return view('pages.cart.show_cart')->with('category',$cate_pro)->with('author',$author);

    }
    public function delete_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');

    }
    public function update_cart_quantity(Request $request){
        $rowId=$request->rowId_book;
        $quantity=$request->quantity_book;
        $id_book=$request->id_book;
        $sp=DB::table('tbl_book')->where('book_id',$id_book)->get();
        foreach($sp as $key => $sp){
            if($sp->book_quantity>=$quantity){
                Cart::update($rowId,$quantity);
            }
            else{
                Session::put('message1','Số lượng cập nhật lớn hơn số lượng trong kho');
            }
        }
        return Redirect::to('show-cart');
    }
}
