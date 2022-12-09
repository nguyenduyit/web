@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin khách hàng
    </div>
    <div class="table-responsive">
    <?php
					$message=Session::get('message');
					if($message){
						echo $message;
            Session::put('message',NULL);
					}
				?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên người mua</th>
            <th>Số điện thoại</th>
           
          </tr>
        </thead>
        <tbody>
            
          <tr>
           
            <td>{{$order_by_id->customer_name}}</td>
            <td>{{$order_by_id->customer_phone}}</td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin vận chuyển
    </div>
    <div class="table-responsive">
    <?php
					$message=Session::get('message');
					if($message){
						echo $message;
            Session::put('message',NULL);
					}
				?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Tên người mua</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
           
          </tr>
        </thead>
        <tbody>
            
          <tr>
            <td>{{$order_by_id->shipping_name}}</td>
            <td>{{$order_by_id->shipping_address}}</td>
            <td>{{$order_by_id->shipping_phone}}</td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div>
   
    <div class="table-responsive">
    <?php
					$message=Session::get('message');
					if($message){
						echo $message;
            Session::put('message',NULL);
					}
				?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên Sản phẩm</th>
            <th>Số lượng</th>
            <th>Gía tiền</th>
            <th>Tổng tiền</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            
          <tr>
             
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$order_by_id->product_name}}</td>
            <td>{{$order_by_id->product_quantity}}</td>
            <td>{{$order_by_id->product_price}}</td>
            <td>{{$order_by_id->order_total}}</td>
          </tr>
          
        </tbody>
      </table>
    </div>
    
  </div>
</div>
<br><br>

@endsection