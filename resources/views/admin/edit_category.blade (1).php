@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật danh mục sách
            </header>
            <?php
	            $message=Session::get('message');
	            if($message){
		            echo '<span class="text-alert">'.$message.'</span>';
		            Session::put('message',NULL);

	            }
	        ?>
            <div class="panel-body">
           
             @foreach($edit_category_product as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{$edit_value->category_name}}" name="category_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize:none" rows="6" type="password" name="category_name_desc"class="form-control" id="exampleInputPassword1" >{{$edit_value->category_desc}}</textarea>
                        </div>
                        <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật</button>
                    </form>
                   
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection