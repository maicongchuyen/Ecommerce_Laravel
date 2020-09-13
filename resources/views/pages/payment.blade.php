@extends('layouts.app')

@section('content')
@php
$setting = DB::table('settings')->first();
$charge = $setting->shiping_charge;
$vat = $setting->vat;
@endphp
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/styles/contact_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/styles/contact_responsive.css') }}">
<div class="contact_form">
 <div class="container">
  <div class="row">
   <div class="col-lg-7" style="border: 1px solid grey; padding:20px; border-radius: 20px;">
    <div class="contact_form_container">
     <div class="contact_form_title text-center">Sản phẩm</div>
     <div class="cart_items">
      <ul class="cart_list">
       @foreach($cart as $row)
       <li class="cart_item clearfix">
        <div class="cart_item_image text-center"></div>
        <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">


         <div class="cart_item_name cart_info_col">
          <div class="cart_item_title text-center"><b>Ảnh</b></div>
          <div class="cart_item_text"><img src="{{ asset($row->options->image) }}" alt="" style="width:70px; height:70px;"></div>
         </div>
         <div class="cart_item_name cart_info_col">
          <div class="cart_item_title"><b>Tên sản phẩm</b></div>
          <div class="cart_item_text">{{ $row->name}}</div>
         </div>
         @if($row->options->color == null)

         @else
         <div class="cart_item_color cart_info_col">
          <div class="cart_item_title"><b>Màu sắc</b></div>
          <div class="cart_item_text">{{ $row->options->color}}</div>
         </div>
         @endif
         @if($row->options->size == null)

         @else
         <div class="cart_item_color cart_info_col">
          <div class="cart_item_title"><b>Kích cỡ</b></div>
          <div class="cart_item_text">{{ $row->options->size}}</div>
         </div>
         @endif

         <div class="cart_item_quantity cart_info_col">
          <div class="cart_item_title"><b>Số lượng</b></div>
          <div class="cart_item_text">{{ $row->qty}}</div>
         </div>
         <div class="cart_item_price cart_info_col">
          <div class="cart_item_title"><b>Giá</b></div>
          <div class="cart_item_text">{{ $row->price }}</div>
         </div>
         <div class="cart_item_total cart_info_col">
          <div class="cart_item_title"><b>Thành tiền</b></div>
          <div class="cart_item_text">{{ $row->price*$row->qty }}đ</div>
         </div>
        </div>
       </li>
       @endforeach
      </ul>
     </div>
     <ul class="list-group col-lg-8" style="float: right;">
      @if (Session::has('coupon'))
      <li class="list-group-item">Tổng hàng(chưa thuế): <span style="float: right;">{{ Session::get('coupon')['balance'] }}đ</span></li>
      <li class="list-group-item">Mã giảm giá: ({{ Session::get('coupon')['name'] }})
       <a href="{{ route('coupon.remove') }}" class="bnt btn-danger btn-sm">x</a>
       <span style="float: right;">{{ Session::get('coupon')['discount'] }}đ</span>
      </li>
      @else
      <li class="list-group-item">Tổng hàng(chưa thuế): <span style="float: right;">{{ Cart::Subtotal() }}</span></li>
      @endif
      <li class="list-group-item">Phí ship: <span style="float: right;">{{ $charge }}đ</span></li>
      <li class="list-group-item">VAT: <span style="float: right;">{{ $vat }}đ</span></li>
      @if (Session::has('coupon'))
      <li class="list-group-item">Tổng tiền: <span style="float: right;">{{ Session::get('coupon')['balance']+ $charge + $vat }}đ</span></li>
      @else
      <li class="list-group-item">Tổng tiền: <span style="float: right;">{{ Cart::Subtotal()+ $charge + $vat }}đ</span></li>
      @endif
     </ul>
    </div>
   </div>
   <div class="col-lg-5" style="border: 1px solid grey; padding:20px; border-radius: 20px;">
    <div class="contact_form_container">
     <div class="contact_form_title text-center">Địa chỉ</div>

     <form action="{{ route('payment.process') }}" method="post" id="contact_form">
      @csrf
      <div class="form-group">
       <label for="exampleInputEmail1">Tên của bạn</label>
       <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Tên của bạn" name="name" required="">
      </div>
      <div class="form-group">
       <label for="exampleInputEmail1">Số điện thoại</label>
       <input type="text" class="form-control" name="phone" aria-describedby="emailHelp" placeholder="Nhập số điện thoại">
      </div>
      <div class="form-group">
       <label for="exampleInputEmail1">Email</label>
       <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Nhập Email của bạn">
      </div>
      <div class="form-group">
       <label for="exampleInputEmail1">Địa chỉ</label>
       <input type="text" class="form-control" name="address" aria-describedby="emailHelp" placeholder="Nhập Địa chỉ của bạn">
      </div>
      <div class="form-group">
       <label for="exampleInputEmail1">Thành Phố</label>
       <input type="text" class="form-control" name="city" aria-describedby="emailHelp" placeholder="Nhập thành phố">
      </div>
      <div class="contact_form_title text-center">Chọn cổng thanh toán</div>
      <div class="form-group">
       <ul class="logos_list">
        <li><input type="radio" name="payment" value="stripe"><img src="{{ asset('public/frontend/images/mastercard.png') }}" style="width:100px; height:60px;"></li>
        <li><input type="radio" name="payment" value="paypal"><img src="{{ asset('public/frontend/images/paypal.png') }}" style="width:100px; height:60px;"></li>
        <li><input type="radio" name="payment" value="ideal"><img src="{{ asset('public/frontend/images/mollie.png') }}" style="width:100px; height:60px;"></li>
       </ul>
      </div>
      <div class="contact_form_button text-center">
       <button type="submit" class="btn btn-info">Thanh toán ngay</button>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>
 <div class="panel"></div>
</div>
@endsection