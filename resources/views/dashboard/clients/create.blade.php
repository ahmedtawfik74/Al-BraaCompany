@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.clients.index')}}"> @lang('site.clients')</a> </li>
                <li class="active">@lang('site.create-client') </li>

            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <h3 class="box-title">@lang('site.create-client')</h3>

                </div>{{--end of box header--}}
                <div class="box-body">
                    @include('partials._errors')
                        <form action="{{ route('dashboard.clients.store') }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                                <div class="form-group">
                                    <label for="name">@lang('site.name')</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                </div>
                           @for($i=0 ; $i <2 ; $i++)
                                <div class="form-group">
                                    <label for="phone">@lang('site.phone')</label>
                                    <input type="text" name="phone[]" id="phone" class="form-control" value="{{ old('phone[]') }}">
                                </div>
                           @endfor


                            <div class="form-group">
                                <label for="address">@lang('site.address')</label>
                                <textarea  name="address" id="address" class="form-control" >{{ old('address') }}</textarea>
                            </div>


                            
                            <div class="form-group">
                                <button class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.create-client')</button>
                            </div>
                        </form>
                </div>{{--end of box body--}}
            </div> {{--end of parent box--}}


        </section><!-- end of content -->

    </div><!-- end of content wrappe                           -->
@endsection