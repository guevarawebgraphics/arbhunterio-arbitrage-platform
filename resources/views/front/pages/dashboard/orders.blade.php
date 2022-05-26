@extends('front.layouts.base')
@section('content')

<section class="page page--dashboard">
    <div id="dashboard">
        <section class="dashboard default-content">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-3">
                        @include('front.pages.dashboard.sections.nav')
                    </div>
                    <div class="col-md-9">
                        <div class="dashboard__content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Orders</h2>
                                    {{-- Static --}}
                                    {{-- <div class="alert alert-warning">
                                        <p>No orders found</p>
                                    </div>
                                    <a href="{{url('shop')}}" class="btn btn--primary mb-5">Start Shopping</a> --}}
                        
                                    {{-- <div class="table-responsive "> --}}
                                    <div class="table mt-5">
                                        <table id="orders-table" class="orders table table-borderd table-vcenter" style="width: 100%;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="text-left" width="100"> Order #</th>
                                                    <th class="text-left" width="200"> Order Date</th>
                                                    <th class="text-left"> Shipped To</th>
                                                    <th class="text-center" width="100">Total</th>
                                                    <th class="text-center hidden">Action</th>
                                                    <th class="text-left" style="display: none;"> Order HTML</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $count => $order)
                                                    @if($count == 0)
                                                    @endif
                                                    <tr><td class="text-left orders__id">{{ $order->reference_no }}</td>
                                                        <td class="text-left orders__date">{{ $order->created_at->format('F d, Y h:i:s A') }}</td>
                                                        <td class="text-left orders__ship">{{ !empty($order->shipping_address) ? $order->shipping_address->first_name . ' ' . $order->shipping_address->last_name : '' }}</td>
                                                        <td class="text-center orders__total">$ {{ number_format($order->total_amount, 2) }}</td>
                                                        <td class="text-center orders__action">
                                                            <div class="btn-group">
                                                                <a 
                                                                    href="javascript:void(0)"
                                                                    class="btn btn--primary details-control"
                                                                    data-order="">
                                                                       Details &nbsp;&nbsp;<i class="fas fa-chevron-down"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none" class="orders-details">
                                                        <td colspan="5">
                                                            <div class="">
                                                                <div class="row">
                                                                    <div class="col-lg-6 pd-h-0">
                                                                        <div class="block">
                                                                            <div class="block-title">
                                                                                <h5><i class="fa fa-credit-card"></i>&nbsp; &nbsp;<strong>  Billing Information</strong></h5>
                                                                            </div>
                                                                            <table class="table table-borderless table-vcenter orders__info">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>To</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->billing_address) ? $order->billing_address->first_name . ' ' . $order->billing_address->last_name : '' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>Address</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->billing_address) ? $order->billing_address->address . ' ' . $order->billing_address->address_2 . ' ' . $order->billing_address->city . ' ' . $order->billing_address->state . ' ' . $order->billing_address->zip . ' ' . $order->billing_address->country : '' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>Email</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->billing_address) ? $order->billing_address->email : '' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>Phone</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->billing_address) ? $order->billing_address->phone : '' }}</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 pd-h-0">
                                                                        <div class="block">
                                                                            <div class="block-title">
                                                                                <h5><i class="fas fa-map-marker-alt"></i>
                                                                                    <strong>
                                                                                        Shipping Information
                                                                                    </strong>
                                                                                </h5>
                                                                            </div>
                                                                            <table class="table table-borderless table-vcenter orders__info">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>To</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->shipping_address) ? $order->shipping_address->first_name . ' ' . $order->shipping_address->last_name : '' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>Address</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->shipping_address) ? $order->shipping_address->address . ' ' . $order->shipping_address->address_2 . ' ' . $order->shipping_address->city . ' ' . $order->shipping_address->state . ' ' . $order->shipping_address->zip . ' ' . $order->shipping_address->country : '' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>Email</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->shipping_address) ? $order->shipping_address->email : '' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class=" text-right" style="width: 20%">
                                                                                        <strong>Phone</strong></td>
                                                                                    <td class=""
                                                                                        style="width: 80%">{{ !empty($order->shipping_address) ? $order->shipping_address->phone : '' }}</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 pd-h-0">
                                                                <div class="block">
                                                                    <div class="block-title">
                                                                        <h5><i class="fa fa-bars"></i>&nbsp; &nbsp;<strong>  Additional Details</strong></h5>
                                                                    </div>
                                                                    <table class="table table-borderless table-vcenter orders__info">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td style="width: 30%" ><strong>Payment Method</strong></td>
                                                                            <td style="width: 70%">
                                                                                {{ $order->payment_details->gateway }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 30%" ><strong>Transaction ID</strong></td>
                                                                            <td style="width: 70%">
                                                                                {{-- {{ $order->payment_details->gateway }} --}}
                                                                                {{ $order->payment_details->transaction_id }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 30%" ><strong>Shipping Method</strong></td>
                                                                            <td style="width: 70%">
                                                                                {{-- {{ $order->payment_details->gateway }} --}}
                                                                                {{ $order->shipping_details->shipping_method }}
                                                                            </td>
                                                                        </tr>
                                                                        @if (!empty($order->coupon_details))
                                                                            <tr>
                                                                                <td style="width: 30%" class="text-right"><strong>Coupon Code</strong></td>
                                                                                <td style="width: 70%">
                                                                                    {{ $order->coupon_details->coupon_code }}
                                                                                    {{ !empty($order->coupon_details->coupon) ?
                                                                                        ($order->coupon_details->coupon->type == 1 ?
                                                                                            '(-' . $order->coupon_details->coupon->value . '%)'
                                                                                            : '(-$ ' . $order->coupon_details->coupon->value . ')' )
                                                                                    : '' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td style="width: 30%" ><strong>Notes</strong></td>
                                                                            <td style="width: 70%">
                                                                                {!! $order->notes !!}
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 pd-h-0">
                                                                <div class="block full">
                                                                    <div class="block-title">
                                                                        <h5>
                                                                            <i class="fa fa-shopping-cart sidebar-nav-icon"></i>&nbsp; &nbsp;<strong>  Products</strong>
                                                                        </h5>
                                                                    </div>
                                                                    <div class="row" style="margin: 0;">
                                                                        <table class="table table-bordered table-vcenter orders__info">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="">
                                                                                    Product
                                                                                </th>
                                                                                <th class="">
                                                                                    Qty
                                                                                </th>
                                                                                <th class="">
                                                                                    Total
                                                                                </th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if (!empty($order->items))
                                                                                    @foreach($order->items as $item_key => $item)
                                                                                        @php( $product = \App\Models\Product::select('sku')->where('title',$item->title)->get()->first() )
                                                                                        <tr>
                                                                                            <!-- <td>
                                                                                                <p style="font-size: 14px;margin: 4px 0;color: #000000;">{{ $item->title }}: $ {{$item->price}}</p>
                                                                                                {{-- <p style="font-size: 14px;margin: 4px 0;"><b>SKU:</b> #00080</p> --}}
                                                                             
                                                                                            </td> -->
                                        
                                                                                            <td>
                                                                                                <div style="margin-left: 15px">
                                                                                                    <b>{{ $item->name }}</b><br>      
                                                                                                    <p style="font-size: 12px;margin: 4px 0;"><b>Product Price:</b> $ {{$item->price}}</p>
                                                                                             
                                                                                                </div>
                                                                                            </td>
                                                                                            <td>
                                                                                                <span>Qty: {{ $item->quantity }}</span>
                                                                                            </td>
                                                                                            <td>
                                                                                                $ {{ $item->total }}
                                                                                            </td>
                                        
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endif
                                                                            <tr>
                                                                                <td>
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <strong>Subtotal</strong>
                                                                                </td>
                                                                                <td>$ {{ number_format($order->subtotal_amount, 2) }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <strong>Shipping</strong>
                                                                                </td>
                                                                                <td>$ {{ number_format($order->shipping_details->total_amount, 2) }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <strong>Tax</strong>
                                                                                </td>
                                                                                <td>
                                                                                    $ {{ number_format($order->tax_details->total_amount, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <strong>Discount</strong>
                                                                                </td>
                                                                                <td>
                                                                                    {{-- - $ {{ number_format($order->coupon_details->total_amount, 2) }} --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                </td>
                                                                                <td class="text-right orders__info__total">
                                                                                    <strong>Total</strong>
                                                                                </td>
                                                                                <td class="orders__info__total">
                                                                                    $ {{ number_format($order->total_amount, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection