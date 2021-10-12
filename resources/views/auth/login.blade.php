@extends('layouts.auth')

@section('content')
    <div class="row w-100">
        <div class="panel panel-default mx-auto login" style="width:400px">
            <div class="panel-heading">{{ ucfirst(config('app.name')) }} @lang('quickadmin.qa_login')</div>
            <div class="panel-body">
                
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>@lang('quickadmin.qa_whoops')</strong> @lang('quickadmin.qa_there_were_problems_with_input'):
                        <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal"
                        role="form"
                        method="POST"
                        action="{{ url('login') }}">
                    <input type="hidden"
                            name="_token"
                            value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="control-label">@lang('quickadmin.qa_email')</label>

                            <input type="email"
                                    class="form-control"
                                    name="email"
                                    value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label class="control-label">@lang('quickadmin.qa_password')</label>

                            <input type="password"
                                    class="form-control"
                                    name="password">
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <a href="{{ route('auth.password.reset') }}">@lang('quickadmin.qa_forgot_password')</a>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <label>
                                <input type="checkbox"
                                        name="remember"> @lang('quickadmin.qa_remember_me')
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit"
                                    class="btn btn-primary"
                                    style="margin-right: 15px;">
                                @lang('quickadmin.qa_login')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection