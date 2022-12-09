<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $product=DB::table('tbl_book')->where('book_status','1')->orderby('book_id','desc')->limit(4)->get();
        return view('pages.home')->with('category',$cate_pro)->with('author',$author)->with('product',$product);
    }
    public function search(Request $request){
        $keyword=$request->search_keyword;
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $search_product=DB::table('tbl_book')->where('book_name','like','%'.$keyword.'%')->get();
        return view('pages.book.search')->with('category',$cate_pro)->with('author',$author)->with('search_product',$search_product);
    }
}
