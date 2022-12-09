<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
{
    //
    public function AuthLogin(){
        if(Session::get('admin_id')){
            $admin_id=Session::get('admin_id');
        }
        else{
            $admin_id=Auth::id();
        }
 
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
         return Redirect::to('admin')->send();
        }
    }
    public function add_category(){
        $this->AuthLogin();
        return view('admin.add_category');
    }

    public function all_category(){
        $this->AuthLogin();
        $all_category_product=DB::table('tbl_category_product')->get();
        $manager_category_product=view('admin.all_category')->with('all_category_product',$all_category_product);
        return view('admin_layout')->with('admin.all_category',$manager_category_product);
    }
    public function save_category(Request $request){
        $this->AuthLogin();
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_desc']=$request->category_name_desc;
        $data['category_status']=$request->category_status;
        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm danh mục thành công');
        return Redirect::to('add-category');
    }
    public function active_category($category_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_id)->update(['category_status'=>1]);
        Session::put('message','Kích hoạt danh mục sản phẩm');
        return Redirect::to('all-category');

    }
    public function unactive_category($category_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_id)->update(['category_status'=>0]);
        Session::put('message','Không Kích hoạt danh mục sản phẩm');
        return Redirect::to('all-category');
        
    }
    public function edit_category($category_id){
        $this->AuthLogin();
        $edit_category_product=DB::table('tbl_category_product')->where('category_id',$category_id)->get();
        $manager_category_product=view('admin.edit_category')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.edit_category',$manager_category_product);
    }
    public function update_category(Request $request,$category_id){
        $this->AuthLogin();
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_desc']=$request->category_name_desc;
        DB::table('tbl_category_product')->where('category_id',$category_id)->update($data);
        Session::put('message','cập nhật danh mục sách thành công');
        return Redirect::to('all-category');

    }
    public function delete_category($category_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_id)->delete();
        Session::put('message','Xóa danh mục sách thành công');
        return Redirect::to('all-category');

    }
    public function show_category_home($category_id){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $category_id_by=DB::table('tbl_book')->join('tbl_category_product','tbl_category_product.category_id','=','tbl_book.category_id')
        ->where('tbl_book.category_id',$category_id)->get();
        $category_name=DB::table('tbl_category_product')->where('category_id',$category_id)->limit(1)->get();
        return view('pages.category.show_category')->with('category',$cate_pro)
        ->with('author',$author)->with('product',$category_id_by)->with('category_name',$category_name);
    }
}
