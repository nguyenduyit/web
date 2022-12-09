@extends('welcome')
@section('content')
<section id="form"><!--form-->
		<div class="container">
            
			<div class="row">
            <?php
            $message=Session::get('email');
			$error=Session::get('message3');
            if($message){
                echo '<h2 style="color:red; font-size:25px;">'.$message.'</h2>';
                Session::put('message2',NULL);
            }
			elseif($error){
				echo '<h2 style="color:red; font-size:25px;">'.$error.'</h2>';
                Session::put('message3',NULL);
			}
            ?>
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
                    <?php
                    $token=$_GET['token'];
                    $email=$_GET['email']
                    ?>
						<h2>CẬP NHẬT MẬT KHẨU</h2>
						<form action="{{URL::to('/update-new-password')}}" method="POST">
							{{csrf_field()}}
							<input type="hidden" name="email_account" value={{$email}} />
                            <input type="hidden" name="token" value={{$token}} />
							<input type="password" name="password_account" placeholder="Mật khẩu mới*" />
                            <!-- <input type="password" name="confirm_password" placeholder="Xác thực mật khẩu*" /> -->
							<button type="submit" class="btn btn-default">Cập nhật</button>
						</form>
					</div><!--/login form-->
				</div>
			</div>
		</div>
	</section><!--/form-->

@endsection