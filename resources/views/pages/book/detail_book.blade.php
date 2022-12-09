@extends('welcome')
@section('content')
@foreach($book as $key => $book_1)
<div class="product-details"><!--product-details-->
	<!-- {{$book_1->book_id}} -->
	<div class="col-sm-5">
		<div class="view-product">
			<img src="{{URL::to('/public/uploads/'.$book_1->book_image)}}" alt="" />
			<h3>ZOOM</h3>
		</div>
		<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
		    <div class="carousel-inner">
				<div class="item active">
					<a href=""><img src="images/product-details/similar1.jpg" alt=""></a>
					<a href=""><img src="images/product-details/similar2.jpg" alt=""></a>
					<a href=""><img src="images/product-details/similar3.jpg" alt=""></a>
				</div>						
			</div>

								  <!-- Controls -->
			<a class="left item-control" href="#similar-product" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="right item-control" href="#similar-product" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div>

	</div>
	<div class="col-sm-7">
		<div class="product-information"><!--/product-information-->
			<img src="images/product-details/new.jpg" class="newarrival" alt="" />
			<h2>{{$book_1->book_name}}</h2>
			<p>ID:{{$book_1->book_id}}</p>
			<p>Kho: {{$book_1->book_quantity}}</p>
			<?php
			$message=Session::get('message');
			if($message){
				echo '<h2 style="color:red">'.$message.'</h2>';
				Session::put('message',NULL);
			}
			?>
			<img src="images/product-details/rating.png" alt="" />
			<form action="{{URL::to('/save-cart')}}" method="post">
				{{csrf_field()}}
				<span>
					<span>{{number_format($book_1->book_price).' '.'VND'}}</span>
					<label>Số lượng:</label>
					<input type="number" name="qty" min="1" value="1" />
					<input type="hidden" name="book_hidden" value="{{$book_1->book_id}}" />
					
					<button type="submit" class="btn btn-fefault cart">
						<i class="fa fa-shopping-cart"></i>
							Thêm giỏ hàng
					</button>
				</span>
			</form>
			<p><b>Tình trạng:</b> In Stock</p>
			<p><b>Danh mục:</b>{{$book_1->category_name}}</p>
			<p><b>Tác giả:</b>{{$book_1->author_name}}</p>
			<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
		</div><!--/product-information-->
	</div>
</div><!--/product-details-->
@endforeach
@endsection