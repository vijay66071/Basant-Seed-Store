@extends('layouts.admin')
@section('content') 

<div class="main-content-inner">

<div class="main-content-wrap">
    <div class="tf-section-2 mb-30">
        <div class="flex gap20 flex-wrap-mobile">
            <div class="w-half">

                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Total Orders</div>
                                <h4>{{$dashboardDates[0]->Total}}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Total Amount</div>
                                <h4>Rs. {{$dashboardDates[0]->TotalAmount}}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Pending Orders</div>
                                <h4>{{$dashboardDates[0]->TotalOrdered}}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wg-chart-default">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Pending Orders Amount</div>
                                <h4>{{$dashboardDates[0]->TotalOrderedAmount}}</h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-half">

                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Delivered Orders</div>
                                <h4>{{$dashboardDates[0]->TotalDelivered}}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Delivered Orders Amount</div>
                                <h4>Rs. {{$dashboardDates[0]->TotalDeliveredAmount}}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Canceled Orders</div>
                                <h4>Rs. {{$dashboardDates[0]->TotalCanceled}}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wg-chart-default">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Canceled Orders Amount</div>
                                <h4>Rs. {{$dashboardDates[0]->TotalCanceledAmount}}</h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="tf-section mb-30">

        <div class="wg-box">
            <div class="flex items-center justify-between">
                <h5>Recent orders</h5>
                <div class="dropdown default">
                    <a class="btn btn-secondary dropdown-toggle" href="{{route('admin.orders')}}">
                        <span class="view-all">View all</span>
                    </a>
                </div>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:70px">OrderNo</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Delivered On</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            
                            <tr>
                                <td class="text-center">{{$order->id}}</td>
                                <td class="text-center">{{$order->name}}</td>
                                <td class="text-center">{{$order->phone}}</td>
                                <td class="text-center">Rs.{{$order->subtotal}}</td>
                                <td class="text-center">Rs.{{$order->tax}}</td>
                                <td class="text-center">{{$order->total}}</td>
                                <td class="text-center">Rs.{{$order->status}}</td>
                                <td class="text-center">{{$order->created_at}}</td>
                                <td class="text-center">{{$order->orderItems->count()}}</td>
                                <td class="text-center">{{$order->delivered_date}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.order.details',['order_id'=>$order->id])}}">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </a>
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
@endsection