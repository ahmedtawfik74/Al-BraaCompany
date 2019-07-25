@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.products.index')}}"> @lang('site.products')</a> </li>
                <li class="active">@lang('site.edit-product') </li>

            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <h3 class="box-title">@lang('site.edit-product')</h3>

                </div>{{--end of box header--}}
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{ route('dashboard.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        {{--<input type="hidden"  name="category_id" value="{{ $category->id }}">--}}
                        <div class="form-group">
                            <label for="category_id">@lang('site.categories')</label>
                            <select  name="category_id" id="category_id" class="form-control" >
                                <option value="">@lang('site.all_categories')</option>
                                @foreach($categories as $category)
                                    <option {{ $product->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label for="name">@lang('site.'.$locale.'.name')</label>
                                <input type="text" name="{{ $locale }}[name]" id="name" class="form-control" value="{{ $product->translate($locale)->name }}">
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('site.'.$locale.'.description')</label>
                                <textarea  name="{{ $locale }}[description]" id="description" class="form-control ckeditor">{{ $product->translate($locale)->description }}</textarea>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label for="image">@lang('site.image')</label>
                            <input type="file" name="image" id="image" class="form-control image">
                        </div>
                        <div class="form-group">
                            <img class="image-preview img-thumbnail" src="{{ $product->image_path }}" style="width: 100px;" alt="">
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">@lang('site.purchase_price')</label>
                            <input type="number" name="purchase_price" step="0.01" id="purchase_price" class="form-control" value="{{ $product->purchase_price }}" >
                        </div>
                        <div class="form-group">
                            <label for="sale_price">@lang('site.sale_price')</label>
                            <input type="number" name="sale_price" step="0.01" id="sale_price" class="form-control" value="{{ $product->sale_price }}">
                        </div>
                        <div class="form-group">
                            <label for="stock">@lang('site.stock')</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}">
                        </div>



                        <div class="form-group">
                            <button class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit-product')</button>
                        </div>
                    </form>
                </div>{{--end of box body--}}
            </div> {{--end of parent box--}}


        </section><!-- end of content -->

    </div><!-- end of content wrappe                           -->
@endsection