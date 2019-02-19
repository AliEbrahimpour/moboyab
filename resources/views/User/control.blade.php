@extends('layouts.user_panel')

@section('body')
    <main class="main">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/user/panel/control" method="post" class="form-horizontal">
                            {{csrf_field()}}
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        کنترل از راه دور
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-hover table-striped table-align-middle mb-0">
                                            <thead>
                                            <tr>
                                                <th width="300px" >موضوع</th>
                                                <th >وضعیت</th>
                                                <th >توضیحات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($actions as $action)
                                            <tr>
                                                <td >
                                                    {{$action->name}}
                                                </td>
                                                <td >
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input name="actions[]" type="checkbox"
                                                               value="{{$action->id}}" class="switch-input"
                                                                @if(in_array($action->id,$event ) )
                                                                    checked
                                                                @endif
                                                        >
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    {{$action->comment}}
                                                </td>
                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button  type="submit" class="btn btn-outline-success"><i class="fa fa-dot-circle-o"></i> ارسال</button>
                            <button type="reset" class="btn  btn-outline-danger"><i class="fa fa-ban"></i> بازیابی</button>

                            <div class="form-actions">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>

    </main>
<!--/.col-->
@endsection


