@extends('welcome')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Đơn hàng chi tiết</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				
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
						@foreach($history_order_detail as $v_content)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('public/uploads/'.$v_content->book_image)}}"  height="100" alt="" /></a>
							</td>
							<td class="cart_description">
								<h4>{{$v_content->product_name}}</h4>
								<!-- <p>Web ID: 1089772</p> -->
							</td>
							<td class="cart_price">
								<p>{{number_format($v_content->product_price).' '.'VND'}}</p>
							</td>
                            <td class="cart_price">
								<p>{{$v_content->product_quantity}}</p>
							</td>
							
							
							<td class="cart_total">
								<p class="cart_total_price">
									<?php
									$subtotal=$v_content->product_price * $v_content->product_quantity;
									echo number_format($subtotal).' '.'VND';
									?>
								</p>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->


@endsection