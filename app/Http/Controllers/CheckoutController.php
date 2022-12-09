<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Customer;
use Illuminate\Support\Collection;
session_start();

class CheckoutController extends Controller
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

    public function login_checkout(){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_pro)->with('author',$author);
    }
    public function add_customer(Request $request){
        $data=array();
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['customer_password']=md5($request->customer_password);
        $data['customer_phone']=$request->customer_phone;

        $customer_id=DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);

        return Redirect::to('/checkout');

    }
    public function checkout(){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $cus_id=Session::get('customer_id');
        $result=DB::table('tbl_customer')->where('customer_id',$cus_id)->get();
        // print_r($result);
        return view('pages.checkout.show_checkout')->with('category',$cate_pro)->with('author',$author)->with('result',$result);

    }

    public function save_checkout_customer(Request $request){
        $data=array();
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_name']=$request->shipping_name;
        $data['shipping_address']=$request->shipping_address;
        $data['shipping_phone']=$request->shipping_phone;
        $data['shipping_note']=$request->shipping_note;

        $shipping_id=DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);

        return Redirect::to('/payment');
        
    }
    public function payment(){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();


        return view('pages.checkout.payment')->with('category',$cate_pro)->with('author',$author);

    }
    public function order_place(Request $request){
        //insert payment method
        $data=array();
        $data['payment_method']=$request->payment_option;
        $data['payment_status']='dang cho xu ly';
        
        $payment_id=DB::table('tbl_payment')->insertGetId($data);
        // insert order
        $order_data=array();
        $order_data['customer_id']=Session::get('customer_id');
        $order_data['shipping_id']=Session::get('shipping_id');
        $order_data['payment_id']=$payment_id;
        $order_data['order_total']=Cart::subtotal();
        $order_data['order_status']='Chờ xác nhận';

        $order_id=DB::table('tbl_order')->insertGetId($order_data);

         // insert order_detail
         $content= Cart::content();
         foreach($content as $v_content){
            $order_detail_data=array();
            $order_detail_data['order_id']=$order_id;
            $order_detail_data['product_id']=$v_content->id;
            $order_detail_data['product_name']=$v_content->name;
            $order_detail_data['product_price']=$v_content->price;
            $order_detail_data['product_quantity']=$v_content->qty;
    
            DB::table('tbl_order_detail')->insert($order_detail_data);

            //cap nhat sp con lai trong kho
            $masp=$v_content->id;
            $sp=DB::table('tbl_book')->where('book_id',$masp)->get();
            $slm=$v_content->qty;
            foreach($sp as $key => $sp){
                $slk=$sp->book_quantity;
                $slc=$slk-$slm;
                DB::table('tbl_book')->where('book_id',$masp)->update(['book_quantity'=>$slc]);
            }

         }
         if($data['payment_method']==1){
             echo 'The ATM';
         }
         else {
             Cart::destroy();
             $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
             $author=DB::table('tbl_author')->where('author_status','1')->get();
             return view('pages.checkout.cash')->with('category',$cate_pro)->with('author',$author);
         }
         
 
        // return Redirect::to('/payment');

    }
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        $email=$request->email_account;
        $password=md5($request->password_account);
        $result=DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }
        else{
            return Redirect::to('/login-checkout');
        }
       
        
    }
    

    public function manage_order(){
        $this->AuthLogin();
        $all_order=DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')->orderBy('order_id','DESC')->get();
        $manage_order=view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manage_order);
       
    }
    public function view_order($order_id){
        $this->AuthLogin();
        $order_by_id=DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_detail','tbl_order.order_id','=','tbl_order_detail.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_detail.*')->first();
        // print_r($order_by_id);
        DB::table('tbl_order')->where('order_id',$order_id)->update(['order_status'=>'đã xác nhận']);
        $manage_order_by_id=view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manage_order_by_id);
        
    }
    public function all_customer(){
        $this->AuthLogin();
        $all_customer=DB::table('tbl_customer')->select('tbl_customer.*')->get();
        $manage_customer=view('admin.all_customer')->with('all_customer',$all_customer);
        return view('admin_layout')->with('admin.all_customer',$manage_customer);
       
    }
    public function history($id){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $history=DB::table('tbl_order')->where('customer_id',$id)->orderBy('order_id','DESC')->get();
        return view('pages.checkout.history')->with('category',$cate_pro)->with('author',$author)->with('history',$history);

    }
    public function cancel_order($id){
        $abc=Session::get('customer_id');
        // DB::table('tbl_order')->where('order_id',$id)->update(['order_status'=>'huy don hang']);
        $result=DB::table('tbl_order_detail')
        ->join('tbl_order','tbl_order.order_id','=','tbl_order_detail.order_id')
        ->join('tbl_book','tbl_book.book_id','=','tbl_order_detail.product_id')
        ->where('tbl_order_detail.order_id',$id)->select('tbl_book.book_id','tbl_book.book_quantity','tbl_order_detail.product_quantity')->get();
        foreach($result as $key => $result){
            $slk=$result->book_quantity;
            $slc=$result->product_quantity;
            $slm=$slk+$slc;
            DB::table('tbl_book')->where('book_id',$result->book_id)->update(['book_quantity'=>$slm]);
        }
        $result1=DB::table('tbl_order')
        ->join('tbl_order_detail','tbl_order.order_id','=','tbl_order_detail.order_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
        ->where('tbl_order.order_id',$id)->select('tbl_order.order_id','tbl_order.shipping_id','tbl_order.payment_id')->get();
        foreach($result1 as $key => $result1){
            DB::table('tbl_order')->where('tbl_order.order_id',$result1->order_id)->delete();
            DB::table('tbl_shipping')->where('tbl_shipping.shipping_id',$result1->shipping_id)->delete();
            DB::table('tbl_payment')->where('tbl_payment.payment_id',$result1->payment_id)->delete();
            DB::table('tbl_order_detail')->where('tbl_order_detail.order_id',$result1->order_id)->delete();
        }
        return Redirect::to('/history/'.$abc);
       
    }
    public function history_order_detail($id){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        $history_order_detail=DB::table('tbl_order_detail')
        ->join('tbl_book','book_id','=','tbl_order_detail.product_id')
        ->where('tbl_order_detail.order_id',$id)->get();
        return view('pages.checkout.history_order_detail')->with('category',$cate_pro)->with('author',$author)->with('history_order_detail',$history_order_detail);

    }
    public function cancel($id){
        $result=DB::table('tbl_order')
        ->where('order_id',$id)->delete();
        // foreach($result as $key => $result){
        //     $slk=$result->book_quantity;
        //     $slc=$result->product_quantity;
        //     $slm=$slk+$slc;
        //     DB::table('tbl_book')->where('book_id',$result->book_id)->update(['book_quantity'=>$slm]);
        // }
        // $result1=DB::table('tbl_order')
        // ->join('tbl_order_detail','tbl_order.order_id','=','tbl_order_detail.order_id')
        // ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        // ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
        // ->where('tbl_order.order_id',$id)->select('tbl_order.order_id','tbl_order.shipping_id','tbl_order.payment_id')->get();
        // foreach($result1 as $key => $result1){
        //     DB::table('tbl_order')->where('tbl_order.order_id',$result1->order_id)->delete();
        //     DB::table('tbl_shipping')->where('tbl_shipping.shipping_id',$result1->shipping_id)->delete();
        //     DB::table('tbl_payment')->where('tbl_payment.payment_id',$result1->payment_id)->delete();
        //     DB::table('tbl_order_detail')->where('tbl_order_detail.order_id',$result1->order_id)->delete();
        // }
        return Redirect::to('/manage-order');
    }
    public function cancel_show_cart(){
        Cart::destroy();
        return Redirect::to('/show-cart');
    }
    public function forget_password(){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        return view('pages.checkout.forget_password')->with('category',$cate_pro)->with('author',$author);

    }
    public function update_password(Request $request){
        $data=$request->all();
        $title_mail="Lấy lại mật khẩu";
        $customer=DB::table('tbl_customer')->where('customer_email',$data['email_account'])->get();
        foreach($customer as $key => $value){
            $customer_id=$value->customer_id;
        }
        if($customer){
            $count_customer=$customer->count();
            if($count_customer==0){
                Session::put('email',"Email chưa được đăng ký");
                return redirect('/forget-password');
            }
            else{
                $token_random=Str::random();
                $customer=DB::table('tbl_customer')->where('customer_id',$customer_id)->get();
                DB::table('tbl_customer')->where('customer_id',$customer_id)->update(['customer_token'=>$token_random]);

                // send mail
                $to_mail=$data['email_account'];
                $link_reset_password=url('/update-new-pass?email='.$to_mail.'&token='.$token_random);
                $data=array("name"=>$title_mail,"body"=>$link_reset_password,'email'=>$data['email_account']);

                Mail::send('pages.checkout.forget_pass_notify',['data'=>$data],function($message) use($title_mail,$data)
                {
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'],$title_mail);

                });
                Session::put('message3','VUI LÒNG VÀO KIỂM TRA MAIL ĐỂ CẬP NHẬT MẬT KHẨU');
                return redirect('/forget-password');

            }
        }
        

        // $def=md5($request->password_account);
        // $ghi=md5($request->confirm_password);
        // if($def!=$ghi){
        //     Session::put('message2','Hai mật khẩu không khớp nhau');
        //     return Redirect::to('/forget-password');
        // }
        // else{
        //     DB::table('tbl_customer')->where('customer_email',$abc)->update(['customer_password'=>$def]);
        //     Session::put('message2','Cập nhật mật khẩu thành công');
        // }
        // return Redirect::to('/login-checkout');
    }
    public function update_new_pass(Request $request){
        $cate_pro=DB::table('tbl_category_product')->where('category_status','1')->get();
        $author=DB::table('tbl_author')->where('author_status','1')->get();
        return view('pages.checkout.new_password')->with('category',$cate_pro)->with('author',$author);
    }
    public function update_new_password(Request $request){
        $data=$request->all();
        $token_random=Str::random();
        $customer=DB::table('tbl_customer')->where('customer_email',$data['email_account'])->where('customer_token',$data['token'])->get();
        $count_customer=$customer->count();
        if($count_customer>0){
            foreach($customer as $key => $value){
                $customer_id=$value->customer_id;
            }
            DB::table('tbl_customer')->where('customer_id',$customer_id)
            ->update(['customer_password'=>md5($data['password_account'])],['customer_token'=>$token_random]);
            return redirect('login-checkout')->with('success','Cập nhật mật khẩu thành công');
        }
        else {
            return redirect('forget-password')->with('fail','Vui lòng nhập lại do quá thời hạn');
        }
    
    }
}
