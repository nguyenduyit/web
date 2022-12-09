<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;

use App\Social; 
use Socialite; 
use App\Login;
use App\Customer;
use App\SocialCustomer; 
use Auth;

session_start();

class AdminController extends Controller
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

    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
           
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            // Session::put('login_normal',true);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }else{

            $login_social = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => '',
                    

                ]);
            }
            $login_social->login()->associate($orang);
            $login_social->save();

            $account_name = Login::where('admin_id',$account->user)->first();

            Session::put('admin_name',$login_social->admin_name);
            Session::put('admin_id',$login_social->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } 
    }


    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        // return $users->id;
        $authUser = $this->findOrCreateUser($users,'google');
        if($authUser){
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
        }
        else {
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
        }
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
      
       
    }

    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }
        else {
            $customer_new = new Social([
                'provider_user_id' => $users->id,
                'provider_user_email' => $user->email,
                'provider' => strtoupper($provider)
            ]);
    
            $orang = Login::where('admin_email',$users->email)->first();
    
                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => '',
                        'admin_phone' => '',
                    ]);
                }
            $customer_new->login()->associate($orang);
            $customer_new->save();
            return $customer_new;
        }
      
    }

    public function login_customer_google(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google')->redirect();

    }

    public function customer_callback_google(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        $users = Socialite::driver('google')->stateless()->user(); 
       
        $authUser = $this->findOrCreateCustomer($users,'google');
        if($authUser){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_name',$account_name->customer_name);
            Session::put('login_normal',true);
            Session::put('customer_id',$account_name->customer_id);
        }
        else {
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_name',$account_name->customer_name);
            Session::put('login_normal',true);
            Session::put('customer_id',$account_name->customer_id);
        }
        return redirect('/checkout')->with('message', 'Đăng nhập thành công');
        
    }

    public function findOrCreateCustomer($users,$provider){
        $authUser = SocialCustomer::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }
        else {
            $customer_new = new SocialCustomer([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);
    
            $customer = Customer::where('customer_email',$users->email)->first();
    
                if(!$customer){
                    $customer = Customer::create([
                        'customer_name' => $users->name,
                        'customer_email' => $users->email,
                        'customer_password' => '',
                        'customer_phone' => '',
                    ]);
                }
            $customer_new->customerLogin()->associate($customer);
            $customer_new->save();
            return $customer_new;
        }
      
    }


    public function index(){
        return view('admin_login');
    }

    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
        $data=$request->all();
        $admin_email=$request->admin_email;
        $admin_password=md5($request->admin_password);
        $login=Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        $login_count=$login->count();
        if($login_count){
            Session::put('admin_name',$login->admin_name);
            Session::put('admin_id',$login->admin_id);
            return Redirect::to('/dashboard');
        }else{
            Session::put('message','Email hoặc mật khẩu sai. Vui lòng nhập lại');
            return Redirect::to('/admin');
        }
    //    $result=DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    //    if($result){
    //        Session::put('admin_name',$result->admin_name);
    //        Session::put('admin_id',$result->admin_id);
    //        return Redirect::to('/dashboard');
    //    }else{
    //         Session::put('message','Email hoặc mật khẩu sai. Vui lòng nhập lại');
    //         return Redirect::to('/admin');
    //    }
    }

    public function log_out(Request $request){
        $this->AuthLogin();
        Session::put('admin_name',NULL);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
     }
}
