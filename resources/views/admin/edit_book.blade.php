@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                THÊM SÁCH
            </header>
            <div class="panel-body">
            <?php
	            $message=Session::get('message');
	            if($message){
		            echo '<span class="text-alert">'.$message.'</span>';
		            Session::put('message',NULL);

	            }
	        ?>
                <div class="position-center">
                    @foreach($edit_book as $key => $edit_value)
                    <form role="form" action="{{URL::to('/update-book/'.$edit_value->book_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sách</label>
                            <input type="text" value="{{$edit_value->book_name}}" name="book_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sách">
                        </div>
                        <label for="exampleInputPassword1">Thuộc danh mục</label>
                            <select name="category_id" class="form-control input-sm m-bot15">
                                @foreach($category_id as $key => $cate)
                                @if($cate->category_id==$edit_value->category_id)
                                <option selected  value="{{$cate->category_id}}">{{$cate->category_name}}</nav></option>
                                @else
                                <option  value="{{$cate->category_id}}">{{$cate->category_name}}</nav></option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <label for="exampleInputPassword1">Tác giả</label>
                            <select name="author_id" class="form-control input-sm m-bot15">
                                @foreach($author_id as $key => $author)
                                @if($author->author_id==$edit_value->author_id)
                                <option selected  value="{{$author->author_id}}">{{$author->author_name}}</nav></option>
                                @else
                                <option  value="{{$author->author_id}}">{{$author->author_name}}</nav></option>
                                @endif
                                <!-- <option value="{{$author->author_id}}">{{$author->author_name}}</nav></option> -->
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sách</label>
                            <textarea style="resize:none"  rows="6" type="password" name="book_desc"class="form-control" id="exampleInputPassword1" >{{$edit_value->book_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Gía sách</label>
                            <input type="text" name="book_price" value="{{$edit_value->book_price}}" class="form-control" id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình sách</label>
                            <input type="file" name="book_image" class="form-control" id="exampleInputEmail1" >
                            <img src="{{URL::to('public/uploads/'.$edit_value->book_image)}}" height="100" width="100">
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số lượng sách</label>
                            <input type="text" value="{{$edit_value->book_quantity}}" name="book_quantity" class="form-control" id="exampleInputEmail1" >
                        </div>
                       
                        <div class="form-group">
                        <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="book_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</nav></option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button type="submit" name="add_book" class="btn btn-info">Cập nhật</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection