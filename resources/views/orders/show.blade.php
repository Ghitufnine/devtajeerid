@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{trans('lang.order_plural')}} <small>{{trans('lang.order_desc')}}</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{!! route('orders.index') !!}">{{trans('lang.order_plural')}}</a>
          </li>
          <li class="breadcrumb-item active">{{trans('lang.order')}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  <div class="card">
    <div class="card-header d-print-none">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="{!! route('orders.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.order_table')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.order')}}</a>
        </li>
        <div class="ml-auto d-inline-flex">
          <li class="nav-item">
            <a class="nav-link pt-1" id="printOrder" href="#"><i class="fa fa-print"></i> {{trans('lang.print')}}</a>
          </li>
        </div>
      </ul>
    </div>
    <div class="card-body">
      <div class="row">
        @include('orders.show_fields')
      </div>
      <div class="box">
          <h3>Detail Alamat Pengambilan</h3>              
      </div><br>
      <div class="row">
          <table class="table">
              <tbody>
                  <tr>
                      <td>Nama Toko</td>
                      <td> : </td>
                      <td>{{ $shops->name }}</td>
                  </tr>
                  <tr>
                    <td>Nomor Penjual</td>
                    <td> : </td>
                    <td><a href="https://api.whatsapp.com/send?phone={{$shops->phone}}">{{ $shops->phone }}</a></td>
                </tr>
                  <tr>
                      <td>Alamat Pengambilan</td>
                      <td> : </td>
                    <td>
                        <a href="http://www.google.com/maps/place/{{$shops->latitude}},{{$shops->longitude}}">
                            {{ $shops->pickup_address }}
                        </a></td>
                    </tr>
                </tbody>
            </table>
      </div>
      @include('food_orders.table')
      <div class="row">
      <div class="col-5 offset-7">
        <div class="table-responsive table-light">
          <table class="table">
            <tbody><tr>
              <th class="text-right">{{trans('lang.order_subtotal')}}</th>
              <td>{!! getPrice($subtotal) !!}</td>
            </tr>
            <tr>
              <th class="text-right">{{trans('lang.order_tax')}} ({!!$order->tax!!}%) </th>
              <td>{!! getPrice($subtotal * $order->tax/100)!!}</td>
            </tr>
            <tr>
              <th class="text-right">{{trans('lang.order_delivery_fee')}}</th>
              <td>{!! getPrice($order['delivery_fee'])!!}</td>
            </tr>

            <tr>
              <th class="text-right">{{trans('lang.order_total')}}</th>
              <td>{!!getPrice($total)!!}</td>
            </tr>
            </tbody></table>
        </div>
      </div>
      </div>
      <div class="clearfix"></div>
      <div class="row d-print-none">
        <!-- Back Field -->
        <div class="form-group col-12 text-right">
          <a href="{!! route('orders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.back')}}</a>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $("#printOrder").on("click",function () {
      window.print();
    });
  </script>
@endpush