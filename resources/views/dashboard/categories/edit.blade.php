@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.categories.index')}}"> @lang('site.categories')</a> </li>
                <li class="active">@lang('site.edit-category') </li>

            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <h3 class="box-title">@lang('site.edit-category')</h3>

                </div>{{--end of box header--}}
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{ route('dashboard.categories.update',$category->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        {{--<input type="hidden"  name="category_id" value="{{ $category->id }}">--}}
                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label for="name">@lang('site.'.$locale.'.name')</label>
                            <input type="text" name="{{ $locale }}[name]" id="name" class="form-control" value="{{ $category->translate($locale)->name }}">
                        </div>

                        @endforeach
                        <div class="form-group">
                            <button class="btn btn-success"><i class="fa fa-edit"></i>@lang('site.edit-category')</button>
                        </div>
                    </form>
                </div>{{--end of box body--}}
            </div> {{--end of parent box--}}


        </section><!-- end of content -->

    </div><!-- end of content wrappe                           -->
@endsection