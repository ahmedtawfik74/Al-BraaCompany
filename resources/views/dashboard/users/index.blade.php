@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> @lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>  @lang('site.dashboard')</a> </li>
                <li><a href="{{ route('dashboard.users.index')}}"><i class="fa fa-users"></i>  @lang('site.users')</a> </li>

            </ol>
        </section>

        <section class="content">
                <div class="box box-primary">
                    <div class="box-header with-border ">
                        <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.users')<small><span class="label label-info"> {{ $users->total() }} </span></small></h3>
                        <form action="{{ route('dashboard.users.index') }}" method="get">
                            <div class="row mt-5">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search" placeholder="@lang('site.search')" value="{{ request()->search }}">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary"><i class="fa fa-search-plus"></i> @lang('site.search')</button>
                                   @if(auth()->user()->hasPermission('create-users'))
                                        <a class="btn btn-success" href="{{ route('dashboard.users.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @else
                                        <a class="btn btn-success disabled" href="#"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>{{--end of box header--}}
                    <div class="box-body">
                        @if($users->count() > 0 )
                            <table class="table table-hover" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.first_name')</th>
                                    <th>@lang('site.last_name')</th>
                                    <th>@lang('site.email')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $index=>$user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><img src="{{ $user->image_path }}" class="img-thumbnail" style="width: 100px;" ></td>
                                        <td>
                                        @if(auth()->user()->hasPermission('update-users'))
                                                <a class="btn btn-info btn-sm" href="{{ route('dashboard.users.edit',$user->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                         @else
                                                <a class="btn btn-info btn-sm disabled" href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                         @endif
                                        @if(auth()->user()->hasPermission('delete-users'))
                                                <form action="{{ route('dashboard.users.destroy',$user->id) }}" method="POST" style="display: inline-block;">
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
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>{{--end of box body--}}
                </div> {{--end of parent box--}}


        </section><!-- end of content -->

    </div><!-- end of content wrappe                           -->
@endsection