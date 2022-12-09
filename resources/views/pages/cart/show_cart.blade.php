@extends('welcome')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<?php
				$content=Cart::content();
				
				?>
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Mô tả</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng cộng</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($content as $v_content)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('public/uploads/'.$v_content->options->image)}}"  height="100" alt="" /></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$v_content->name}}</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($v_content->price).' '.'VND'}}</p>
							</td>
							<?php
									$message=Session::get('message1');
									if($message){
										echo '<h5 style="text-align:center;color:red;font-size:30px">'.$message.'</h5>';
										Session::put('message1',NULL);
									}
									?>
							<td class="cart_quantity">
							
								<div class="cart_quantity_button">
								
									<form action="{{URL::to('/update-cart-quantity')}}" method="post">
										{{csrf_field()}}
									<input type="hidden" value="{{$v_content->rowId}}" name="rowId_book">
									<input type="hidden" value="{{$v_content->id}}" name="id_book">
									<input class="cart_quantity_input" type="text" name="quantity_book" value="{{$v_content->qty}}" autocomplete="off" size="2">
									<input type="submit" value="Cập nhật" name="update_qty">
									</form>
									
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									<?php
									$subtotal=$v_content->qty * $v_content->price;
									echo number_format($subtotal).' '.'VND';
									?>
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('delete-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
			</div>
			<a class="btn btn-primary" href="{{URL::to('/cancel-show-cart')}}">Hủy đơn</a>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			
			<div class="row">
				
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Tổng<span>{{Cart::subtotal()}}</span></li>
							<!-- <li>Eco Tax <span>$2</span></li> -->
							<li>Shipping Cost <span>Free</span></li>
							<li>Total <span>{{Cart::subtotal()}}</span></li>
						</ul>
						<?php
									$customer_id=Session::get('customer_id');
									if($customer_id!=NULL){
									?>
									<a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a>
									<?php
									}else {
										?>
									<a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Thanh toán</a>
									<?php
									}
								?>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->

@endsection