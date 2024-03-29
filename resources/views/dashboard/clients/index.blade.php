@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.clients.index')}}"><i class="fa fa-male"></i>  @lang('site.clients')</a> </li>

            </ol>
        </section>

        <section class="content">
                <div class="box box-primary">
                    <div class="box-header with-border ">
                        <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.clients')<small><span class="label label-info"> {{ $clients->total() }} </span></small></h3>
                        <form action="{{ route('dashboard.clients.index') }}" method="get">
                            <div class="row mt-5">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search" placeholder="@lang('site.search')" value="{{ request()->search }}">
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-primary"><i class="fa fa-search-plus"></i> @lang('site.search')</button>
                                   @if(auth()->user()->hasPermission('create-clients'))
                                        <a class="btn btn-success" href="{{ route('dashboard.clients.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @else
                                        <a class="btn btn-success disabled" href="#"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>{{--end of box header--}}
                    <div class="box-body">
                        @if($clients->count() > 0 )
                            <table class="table table-hover" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.address')</th>
                                    <th>@lang('site.add-order')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $index=>$client)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ is_array($client->phone) ? implode($client->phone,'-') : $client->phone }} </td>
                                        <td>{{ $client->address }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('dashboard.clients.orders.create',$client->id) }}">@lang('site.add-order')</a>
                                        </td>
                                        <td>
                                        @if(auth()->user()->hasPermission('update-clients'))
                                                <a class="btn btn-info btn-sm" href="{{ route('dashboard.clients.edit',$client->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                         @else
                                                <a class="btn btn-info btn-sm disabled" href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                         @endif
                                        @if(auth()->user()->hasPermission('delete-clients'))
                                                <form action="{{ route('dashboard.clients.destroy',$client->id) }}" method="POST" style="display: inline-block;">
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
                            {{ $clients->appends(request()->query())->links() }}
                        </div>
                    </div>{{--end of box body--}}
                </div> {{--end of parent box--}}


        </section><!-- end of content -->

    </div><!-- end of content wrappe                           -->
@endsection