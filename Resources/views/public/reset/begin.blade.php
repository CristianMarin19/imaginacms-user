@extends('layouts.master')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')
    {{-- Need Publish --}}
    <link href="{!! Module::asset('iprofile:css/base.css') !!}" rel="stylesheet" type="text/css" />
    <div class="page page-profile py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="login-logo">
                        <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
                    </div>
                    <!-- /.login-logo -->
                    <div class="login-box-body">
                        <p class="login-box-msg">{{ trans('user::auth.to reset password complete this form') }}</p>
                        @include('isite::frontend.partials.notifications')

                        {!! Form::open(['route' => 'reset.post']) !!}
                            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" class="form-control" autofocus
                                       name="email" placeholder="{{ trans('user::auth.email') }}" value="{{ old('email')}}">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">
                                        {{ trans('user::auth.reset password') }}
                                    </button>
                                </div>
                            </div>
                        {!! Form::close() !!}

                        <a href="{{ route('login') }}" class="text-center">{{ trans('user::auth.I remembered my password') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
