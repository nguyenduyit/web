@extends('welcome')
@section('content')
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<?php
					$message=Session::get('message2');
					if($message){
						echo '<h2 style="color:red; font-size:25px;text-align:center;">'.($message).'</h2>';
						Session::put('message2',NULL);
					}
					?>
					@if(session()->has('success'))
						<div class="alert alert-sucess">
							{!! session()->get('fail') !!}
						</div>
					@endif
					<div class="login-form"><!--login form-->
						<h2>Đăng nhập tài khoản của bạn</h2>
						<form action="{{URL::to('/login-customer')}}" method="POST">
							{{csrf_field()}}
							<input type="text" name="email_account" placeholder="Email" />
							<input type="password" name="password_account" placeholder="Mật khẩu" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<span class="btn btn-secondary">
								<a  href="{{URL::to('/forget-password')}}">Quên mật khẩu</a>
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>
					</div><!--/login form-->
					<style>
						Ul.list-login{
							margin:10px;
						}
						ul.list-login li{
							display:inline;
							bottom: 10px;
						}
					</style>
					<ul class="list-login">
						<li>
							<a href="{{url('login-customer-google')}}"><img width="10%" src="{{asset('public/frontend/images/gg.png')}}"></a>
						</li>

						<li>
							<a href="{{url('login-customer-facebook')}}"><img width="10%" src="{{asset('public/frontend/images/fb.png')}}"></a>
						</li>
					</ul>
				</div>
				

				<div class="col-sm-1">
					<h2 class="or">HOẶC</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Đăng ký!</h2>
						<form action="{{URL::to('/add-customer')}}" method="post">
                            {{csrf_field()}}
							<input type="text" name="customer_name" placeholder="Họ và tên"/>
							<input type="email" name="customer_email" placeholder="Địa chỉ email"/>
							<input type="password" name="customer_password" placeholder="Mật khẩu"/>
                            <input type="text" name="customer_phone" placeholder="Số điện thoại"/>
							<button type="submit" class="btn btn-default">Đăng ký</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->

@endsection