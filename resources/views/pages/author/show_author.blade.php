
@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
@foreach($author_name as $key => $author_1)
	<h2 class="title text-center">{{$author_1->author_name}}</h2>
@endforeach
	@foreach($product as $key => $book)
	<a href="{{URL::to('/chi-tiet-sach/'.$book->book_id)}}">
		<div class="col-sm-4">
			<div class="product-image-wrapper">
				<div class="single-products">
					<div class="productinfo text-center">
						<img src="{{URL::to('public/uploads/'.$book->book_image)}}" alt="" />
						<h2>{{number_format($book->book_price).' '.'VND'}}</h2>
						<p>{{$book->book_name}}</p>
						<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
					</div>
					
				</div>
			
			</div>
		</div>	
	</a>
	@endforeach
</div><!--features_items-->


@endsection
