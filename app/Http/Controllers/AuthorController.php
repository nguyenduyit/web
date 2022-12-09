<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
session_start();


class AuthorController extends Controller
{   
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
    public function add_author(){
        $this->AuthLogin();
        return view('admin.add_author');
    }

    public function all_author(){
        $this->AuthLogin();
        $all_author=DB::table('tbl_author')->get();
        $manager_author=view('admin.all_author')->with('all_author',$all_author);
        return view('admin_layout')->with('admin.all_author',$manager_author);
    }
    public function save_author(Request $request){
        $this->AuthLogin();
        $data=array();
        $data['author_name']=$request->author_name;
        $data['author_desc']=$request->author_desc;
        $data['author_status']=$request->author_status;
        DB::table('tbl_author')->insert($data);
        Session::put('message','Thêm tác giả thành công');
        return Redirect::to('add-author');
    }
    public function active_author($author_id){
        $this->AuthLogin();
        DB::table('tbl_author')->where('author_id',$author_id)->update(['author_status'=>1]);
        Session::put('message','Kích hoạt tác giả');
        return Redirect::to('all-author');

    }
    public function unactive_author($author_id){
        $this->AuthLogin();
        DB::table('tbl_author')->where('author_id',$author_id)->update(['author_status'=>0]);
        Session::put('message','Không Kích hoạt tác giả');
        return Redirect::to('all-author');
        
    }
    public function edit_author($author_id){
        $this->AuthLogin();
        $edit_author=DB::table('tbl_author')->where('author_id',$author_id)->get();
        $manager_author=view('admin.edit_author')->with('edit_author',$edit_author);
        return view('admin_layout')->with('admin.edit_author',$manager_author);
    }
    public function update_author(Request $request,$author_id){
        $this->AuthLogin();
        $data=array();
        $data['author_name']=$request->author_name;
        $data['author_desc']=$request->author_desc;
        DB::table('tbl_author')->where('author_id',$author_id)->update($data);
        Session::put('message','cập nhật tác giả thành công');
        return Redirect::to('all-author');

    }
    public function delete_author($author_id){
        $this->AuthLogin();
        DB::table('tbl_author')->where('author_id',$author_id)->delete();
        Session::put('message','Xóa tác giả thành công');
        return Redirect::to('all-author');

    }
    public function show_author_home($author_id){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $author_id_by=DB::table('tbl_book')->join('tbl_author','tbl_author.author_id','=','tbl_book.author_id')
        ->where('tbl_author.author_id',$author_id)->get();
        $author_name=DB::table('tbl_author')->where('author_id',$author_id)->limit(1)->get();
        return view('pages.author.show_author')->with('category',$cate_pro)
        ->with('author',$author)->with('product',$author_id_by)->with('author_name',$author_name);
    }
}
