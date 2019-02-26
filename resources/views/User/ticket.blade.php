@extends('layouts.admin_panel')

@section('css')
    <style>
        label{
            font-size: 20px;
        }
    </style>
@endsection

@section('body')
    <main class="main">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <br>
                    <h3 style="padding-right: 10px;" class="panel-heading">ثبت درخواست جدید</h3>
                    <br>

                    <div class="panel-body">
                        @include('includes.flash')

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/panel/ticket') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label  for="title" class="col-md-4 control-label">عنوان</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                                <label for="priority" class="col-md-4 control-label">اولویت</label>

                                <div class="col-md-6">
                                    <select id="priority" type="" class="form-control" name="priority">
                                        <option value="">انتخاب کنید</option>
                                        <option value="low">کم</option>
                                        <option value="medium">متوسط</option>
                                        <option value="high">زیاد</option>
                                    </select>

                                    @if ($errors->has('priority'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <label for="message" class="col-md-4 control-label">متن درخواست</label>

                                <div class="col-md-6">
                                    <textarea rows="10" id="message" class="form-control" name="message"></textarea>

                                    @if ($errors->has('message'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-ticket"></i> ارسال تیکت
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection