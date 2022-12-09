@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                THÊM TÁC GIẢ
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
                    <form role="form" action="{{URL::to('/save-author')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên tác giả</label>
                            <input type="text" name="author_name" class="form-control" id="exampleInputEmail1" placeholder="Tên tác giả">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea style="resize:none" rows="6" type="password" name="author_desc"class="form-control" id="exampleInputPassword1" placeholder="Mô tả"></textarea>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="author_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</nav></option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button type="submit" name="add_author" class="btn btn-info">Thêm</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection