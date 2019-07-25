@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.orders')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.orders.index')}}"><i class="fa fa-first-order"></i>  @lang('site.orders')</a> </li>

            </ol>
        </section>

        <section class="content">
           <div class="row">
    {{-- ///////////////////////// Right column/////////////////////////////////////////////// --}}
              <div class="col-md-8">
                 <div class="box box-primary">
                <div class="box-header with-border ">
                    <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.orders')<small><span class="label label-info">{{ $orders->count() }}</span></small></h3>
                    <form action="{{ route('dashboard.orders.index') }}" method="get">
                        <div class="row mt-5">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="search" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary"><i class="fa fa-search-plus"></i> @lang('site.search')</button>
                            </div>
                        </div>
                    </form>
                </div>{{--end of box header--}}

                     <div class="box-body">
                         @if($orders->count() > 0 )
                             <table class="table table-hover" >
                                 <thead>
                                 <tr>
                                     <th>#</th>
                                     <th>@lang('site.client_name')</th>
                                     <th>@lang('site.price')</th>
                                     <th>@lang('site.status')</th>
                                     <th>@lang('site.created_at')</th>
                                     <th>@lang('site.action')</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 @foreach($orders as $index=>$order)
                                     <tr>
                                         <td>{{ $index + 1 }}</td>
                                         <td>{{ $order->client->name }}</td>
                                         <td>{{ number_format($order->total_price,2) }} </td>
                                         <td><a href="#" class="btn btn-warning btn-sm">@lang('site.compelte')</a> </td>
                                         <td>{{ date('M j, Y  h: i a',strtotime($order->created_at)) }}</td>
                                         {{--  ->toFormattedDateString()  --}}
                                         <td>
                                             <button class="btn btn-primary btn-sm order-products"
                                                     data-url="{{ route('dashboard.orders.products', $order->id) }}"
                                                     data-method="get"
                                             >
                                                 <i class="fa fa-list"></i>
                                                 @lang('site.show')
                                             </button>
                                             @if(auth()->user()->hasPermission('update-clients'))
                                                 <a class="btn btn-warning btn-sm" href="{{ route('dashboard.clients.orders.edit',['client'=>$order->client->id,'order'=>$order->id]) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                             @else
                                                 <a class="btn btn-warning btn-sm disabled" href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                             @endif
                                             @if(auth()->user()->hasPermission('delete-clients'))
                                                 <form action="{{ route('dashboard.orders.destroy',$order->id) }}" method="POST" style="display: inline-block;">
                                                     {{ csrf_field() }}
                                                     {{ method_field('delete') }}

                                                     <button class="btn btn-danger delete btn-sm" type="submit"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                 </form>
                                             @else
                                                 <a class="btn btn-danger btn-sm disabled" href="#"><i class="fa fa-trash"></i> @lang('site.delete')</a>
                                             @endif

                                         </td>
                                     </tr>
                                 @endforeach
                                 </tbody>
                             </table>
                         @else
                             <h2>@lang('site.no_data_found')</h2>
                         @endif
                         <div style="width:40%;margin: auto;">
                             {{ $orders->appends(request()->query())->links() }}
                         </div>
                     </div>{{--end of box body--}}

            </div> {{--end of parent box--}}
              </div>

         {{-- //////////////////////////////////////// left column ///////////////////////////// --}}
              <div class="col-md-4">
                  <div class="box box-primary">
                      <div class="box-header with-border ">
                          <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.products')</h3>
                      </div>{{--end of box header--}}
                      <div class="box-body">
                          <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                              <div class="loader"></div>
                              <p style="margin-top: 10px">@lang('site.loading')</p>
                          </div>
                          <div id="order-product-list">

                          </div><!-- end of order product list -->
                      </div><!-- end of box body -->
                  </div> {{--end of parent box--}}
               </div>
          {{-- ////////////////////////////////////////  ///////////////////////////// --}}

           </div> {{--end of parent box--}}
        </section><!-- end of content -->
    </div><!-- end of content wrappe-->
@endsection