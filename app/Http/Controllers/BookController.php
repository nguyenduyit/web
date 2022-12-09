<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
session_start();

class BookController extends Controller
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
    public function add_book(){
        $this->AuthLogin();
        $cate=DB::table('tbl_category_product')->orderby('category_id')->get();
        $author=DB::table('tbl_author')->orderby('author_id')->get();
        return view('admin.add_book')->with('category_id',$cate)->with('author_id',$author);

    }
    public function all_book(){
        $this->AuthLogin();
        $all_book=DB::table('tbl_book')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_book.category_id')
        ->join('tbl_author','tbl_author.author_id','=','tbl_book.author_id')->get();
        $manager_book=view('admin.all_book')->with('all_book',$all_book);
        return view('admin_layout')->with('admin.all_book',$manager_book);

    }
    public function save_book(Request $request){
        $this->AuthLogin();
        $data=array();
        $data['book_name']=$request->book_name;
        $data['category_id']=$request->category_id;
        $data['author_id']=$request->author_id;
        $data['book_desc']=$request->book_desc;
        $data['book_price']=$request->book_price;
        $data['book_quantity']=$request->book_quantity;
        // $data['book_image']=$request->book_image;
        $data['book_status']=$request->book_status;
        $get_image=$request->file('book_image');
        if($get_image){
            $get_name_image=$get_image->getClientOriginalName(); // lay ten cua anh
            $name_image=current(explode('.',$get_name_image)); // tach ten bo dau .
            $new_image=$name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();// lay phan mo rong
            $get_image->move('public/uploads',$new_image);
            $data['book_image']=$new_image;
            DB::table('tbl_book')->insert($data);
            Session::put('message','Thêm sách thành công');
            return Redirect::to('add-book');

        }
        $data['book_image']='';
        DB::table('tbl_book')->insert($data);
        Session::put('message','Thêm sách thành công');
        return Redirect::to('all-book');

    }
    public function edit_book($book_id){
        $this->AuthLogin();
        $cate=DB::table('tbl_category_product')->orderby('category_id')->get();
        $author=DB::table('tbl_author')->orderby('author_id')->get();
        $edit_book=DB::table('tbl_book')->where('book_id',$book_id)->get();
        $manager_book=view('admin.edit_book')->with('edit_book',$edit_book)->with('category_id',$cate)->with('author_id',$author);
        return view('admin_layout')->with('admin.edit_book',$manager_book);
    }
    public function update_book(Request $request,$book_id){
        $this->AuthLogin();
        $data=array();
        $data['book_name']=$request->book_name;
        $data['category_id']=$request->category_id;
        $data['author_id']=$request->author_id;
        $data['book_desc']=$request->book_desc;
        $data['book_price']=$request->book_price;
        // $data['book_image']=$request->book_image;
        $data['book_quantity']=$request->book_quantity;
        $data['book_status']=$request->book_status;
        $get_image=$request->file('book_image');
        if($get_image){
            $get_name_image=$get_image->getClientOriginalName();
            $name_image=current(explode('.',$get_name_image));
            $new_image=$name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads',$new_image);
            $data['book_image']=$new_image;
            DB::table('tbl_book')->where('book_id',$book_id)->update($data);
            Session::put('message','Cập nhật sách thành công');
            return Redirect::to('all-book');

        }
        // $data['book_image']='';
        DB::table('tbl_book')->where('book_id',$book_id)->update($data);
        Session::put('message','Cập nhật sách thành công');
        return Redirect::to('all-book');
    }
    public function delete_book($book_id){
        $this->AuthLogin();
        DB::table('tbl_book')->where('book_id',$book_id)->delete();
        Session::put('message','Xóa sách thành công');
        return Redirect::to('all-book');
    }

    public function active_book($book_id){
        $this->AuthLogin();
        DB::table('tbl_book')->where('book_id',$book_id)->update(['book_status'=>1]);
        Session::put('message','Kích hoạt sách');
        return Redirect::to('all-book');

    }
    public function unactive_book($book_id){
        $this->AuthLogin();
        DB::table('tbl_book')->where('book_id',$book_id)->update(['book_status'=>0]);
        Session::put('message','Không Kích hoạt sách');
        return Redirect::to('all-book');

    }
    public function detail_book($book_id){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $book=DB::table('tbl_book')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_book.category_id')
        ->join('tbl_author','tbl_author.author_id','=','tbl_book.author_id')
        ->where('tbl_book.book_id',$book_id)->get();
        return view('pages.book.detail_book')->with('category',$cate_pro)
        ->with('author',$author)->with('book',$book);

    }

    
}
