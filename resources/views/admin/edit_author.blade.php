@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật tác giả
            </header>
            <?php
	            $message=Session::get('message');
	            if($message){
		            echo '<span class="text-alert">'.$message.'</span>';
		            Session::put('message',NULL);

	            }
	        ?>
            <div class="panel-body">
           
             @foreach($edit_author as $key => $author_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-author/'.$author_value->author_id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên tác giả</label>
                            <input type="text" value="{{$author_value->author_name}}" name="author_name" class="form-control" id="exampleInputEmail1" placeholder="Tên tác gải">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả tác giả</label>
                            <textarea style="resize:none" rows="6" type="password" name="author_desc"class="form-control" id="exampleInputPassword1" >{{$author_value->author_desc}}</textarea>
                        </div>
                        <button type="submit" name="update_author" class="btn btn-info">Cập nhật</button>
                    </form>
                   
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection