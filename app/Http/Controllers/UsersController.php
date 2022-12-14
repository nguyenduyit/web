<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use App\Admin;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class UsersController extends Controller
{
    //
    public function index(){
        $admin=Admin::with('roles')->orderBy('admin_id','DESC')->paginate(5);
        return view('admin.users.all_users')->with(compact('admin'));
    }
    public function add_user(){
        return view('admin.users.add_user');
    }
    public function assign_roles(Request $request){
        // $data=$request->all();
        if(Auth::id()==$request->admin_id){
            return redirect()->back()->with('message','Không được phần quyền chính mình');
        }
        $user=Admin::where('admin_email',$request->admin_email)->first();
        $user->roles()->detach();
        if($request->author_role){
            $user->roles()->attach(Roles::where('name','author')->first());
        }
        if($request->admin_role){
            $user->roles()->attach(Roles::where('name','admin')->first());
        }
        if($request->user_role){
            $user->roles()->attach(Roles::where('name','user')->first());
        }
        return redirect()->back()->with('message','Cấp quyền thành công');
    }
    public function store_user(Request $request){
        $data=$request->all();
        $admin = new Admin();
        $admin->admin_name=$data['admin_name'];
        $admin->admin_password=md5($data['admin_password']);
        $admin->admin_phone=$data['admin_phone'];
        $admin->admin_email=$data['admin_email'];
        $admin->save();
        $admin->roles()->attach(Roles::where('name','user')->first());
        Session::put('message','Thêm user thành công');
        return Redirect::to('users');
    }

    public function delete_user_roles($admin_id){
        if(Auth::id()==$admin_id){
            return redirect()->back()->with('message','Không được xoá chính mình');
        }
        $admin=Admin::find($admin_id);
        if($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Xoá user thành công');
       
    }
    public function impersonate($admin_id){
        $user=Admin::where('admin_id',$admin_id)->first();
        if($user){
            session()->put('impersonate',$user->admin_id);
        }
        return redirect('/users');
    }
    public function impersonate_destroy(){
        session()->forget('impersonate');
        return redirect('/users');
    }
}
