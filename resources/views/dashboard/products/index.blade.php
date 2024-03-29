@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.products.index')}}"><i class="fa fa-products"></i>  @lang('site.products')</a> </li>

            </ol>
        </section>

        <section class="content">
                <div class="box box-primary">
                    <div class="box-header with-border ">
                        <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.products')<small><span class="label label-info"> {{ $products->total() }} </span></small></h3>
                        <form action="{{ route('dashboard.products.index') }}" method="get">
                            <div class="row mt-5">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search" placeholder="@lang('site.search')" value="{{ request()->search }}">
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="category_id" >
                                        <option value="">@lang('site.all_categories')</option>
                                        @foreach($categories as $category)
                                            <option {{ request()->category_id == $category->id ? 'selected': '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary"><i class="fa fa-search-plus"></i> @lang('site.search')</button>
                                   @if(auth()->user()->hasPermission('create-products'))
                                        <a class="btn btn-success" href="{{ route('dashboard.products.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @else
                                        <a class="btn btn-success disabled" href="#"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>{{--end of box header--}}
                    <div class="box-body">
                        @if($products->count() > 0 )
                            <table class="table table-hover" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.description')</th>
                                    <th>@lang('site.category')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.stock')</th>
                                    <th>@lang('site.purchase_price')</th>
                                    <th>@lang('site.sale_price')</th>
                                    <th>@lang('site.profit_percent') %</th>
                                    <th>@lang('site.profit') </th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $index=>$product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{!!  $product->description !!}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td><img src="{{ $product->image_path }}" alt="" class="img-thumbnail" style="width: 100px;"></td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->purchase_price }}</td>
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->profit_percent }} %</td>
                                        <td>{{ $product->profit }} </td>
                                        <td>
                                        @if(auth()->user()->hasPermission('update-products'))
                                                <a class="btn btn-info btn-sm" href="{{ route('dashboard.products.edit',$product->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                         @else
                                                <a class="btn btn-info btn-sm disabled" href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                         @endif
                                        @if(auth()->user()->hasPermission('delete-products'))
                                                <form action="{{ route('dashboard.products.destroy',$product->id) }}" method="POST" style="display: inline-block;">
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
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>{{--end of box body--}}
                </div> {{--end of parent box--}}


        </section><!-- end of content -->

    </div><!-- end of content wrappe                           -->
@endsection