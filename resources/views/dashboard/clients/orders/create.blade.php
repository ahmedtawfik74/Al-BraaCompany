@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.orders')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.clients.index')}}"><i class="fa fa-male"></i>  @lang('site.clients')</a> </li>
                <li><a href="#"><i class="fa fa-first-order"></i>  @lang('site.add-order')</a> </li>

            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title" style="margin-bottom: 10px">@lang('site.categories')<small><span class="label label-info"> {{ $categories->count() }} </span></small></h3>
                        </div><!-- end of box header -->

                        <div class="box-body">
                            @include('partials._errors')
                            @foreach($categories as $category)
                                <div class="panel-group">

                                    <div class="panel panel-info">

                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#{{ str_replace( ' ', '-',$category->name ) }}"> {{  $category->name }}</a>
                                            </h4>
                                        </div>
                                        <div id="{{ str_replace( ' ', '-',$category->name ) }}" class="panel-collapse collapse">

                                            <div class="panel-body">
                                                @if($category->products->count() > 0 )
                                                    <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('site.name')</th>
                                                            <th>@lang('site.stock')</th>
                                                            <th>@lang('site.price')</th>
                                                            <th>@lang('site.add')</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody>
                                                        @foreach($category->products as $product )
                                                            <tr>
                                                                <td>{{ $product->name }}</td>
                                                                <td>{{ $product->stock }}</td>
                                                                <td>{{ number_format($product->sale_price) }}</td>
                                                                <td><a href="#" class="btn btn-success btn-sm add-product-btn "
                                                                       id="product-{{$product->id}}"
                                                                       data-name="{{ $product->name }}"
                                                                       data-price="{{ $product->sale_price }}"
                                                                       data-id="{{ $product->id }}"><i class="fa fa-plus"></i> </a></td>
                                                            </tr>
                                                         @endforeach
                                                        </tbody>
                                                    </table><!-- end of table -->
                                                @else
                                                    <h3> @lang('site.no_data_found')</h3>
                                                @endif
                                            </div><!-- end of panel body -->
                                        </div><!-- end of panel collapse -->
                                    </div>
                                </div>
                             @endforeach
                        </div>{{--end of body categories box--}}

                    </div>
                     </div> {{--end of parent box--}}
                {{-- //////////////////////////////////// --}}
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">@lang('site.orders')</h3>
                            </div><!-- end of box header -->
                            <div class="box-body">

                                <form action="{{ route('dashboard.clients.orders.store',$client->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('POST') }}
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>@lang('site.product')</th>
                                            <th>@lang('site.quantity')</th>
                                            <th>@lang('site.price')</th>
                                        </tr>
                                        </thead>

                                        <tbody class="order-list">
                                        </tbody>
                                    </table><!-- end of table -->
                                    <h4>@lang('site.total') : <span class="total-price">0</span></h4>
                                    <button type="submit" class="btn btn-primary btn-block disabled" id="add-order-form-btn"><i class="fa fa-plus"></i> @lang('site.add-order')</button>
                                </form>
                            </div><!-- end of box body -->
                        </div><!-- end of box -->
                    </div> {{--end of parent box--}}
                {{-- //////////////////////////////////// --}}
                </div>{{--end of row --}}
        </section><!-- end of content -->
    </div><!-- end of content wrappe                           -->
@endsection