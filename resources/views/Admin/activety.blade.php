@extends('layouts.admin_panel')
@section('body')
    <main class="main">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div style="float: left;" class="card-header">
                        <h4> فرم ثبت نامی ها بدون کد معرف</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>نام کاربری</th>
                                <th>نقش</th>
                                <th>تاریخ عضویت</th>
                                <th>ایمیل</th>
                                <th>اعتبار</th>
                                <th>وضعیت کاربر</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->firstname.' '.$user->lastname}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->credit}}</td>
                                    <td>

                                        @if($user->account_status == 'active')
                                            <span class="badge badge-success">Active</span>

                                        @elseif($user->account_status == 'block')
                                            <span class="badge badge-danger">Block</span>

                                        @elseif($user->account_status == 'deactive')
                                            <span class="badge badge-warning">DeActive</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">

                                <li class="page-item active">
                                    {{$users->render()}}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--/.col-->


            <div class="col-lg-12">
                <div class="card">
                    <div style="float: left;" class="card-header">
                        <h4> فرم ثبت نامی ها با کد معرف</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>نام کاربری</th>
                                <th>نقش</th>
                                <th>تاریخ عضویت</th>
                                <th>ایمیل</th>
                                <th>کد معرف</th>
                                <th>اعتبار</th>
                                <th>وضعیت کاربر</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($callers as $caller)
                                <tr>
                                    <td>{{$caller->firstname.' '.$caller->lastname}}</td>
                                    <td>{{$caller->role}}</td>
                                    <td>{{$caller->created_at}}</td>
                                    <td>{{$caller->email}}</td>
                                    <td>{{\App\User::find($caller->caller_id)->code}}</td>
                                    <td>{{$caller->credit}}</td>
                                    <td>

                                        @if($caller->account_status == 'active')
                                            <span class="badge badge-success">Active</span>

                                        @elseif($caller->account_status == 'block')
                                            <span class="badge badge-danger">Block</span>

                                        @elseif($caller->account_status == 'deactive')
                                            <span class="badge badge-warning">DeActive</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">

                                <li class="page-item active">
                                    {{$callers->render()}}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-lg-12">
                <div class="card">
                    <div style="float: left;" class="card-header">
                        <h4> کاربران فعال</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>نام کاربری</th>
                                <th>نقش</th>
                                <th>تعداد عضویت</th>
                                <th>کد معرف</th>
                                <th>وضعیت کاربر</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bests as $best)
                                @php $call = \App\User::find($best->caller_id)@endphp
                                <tr>
                                    <td>{{$call->firstname.' '
                                    .$call->lastname}}</td>
                                    <td>{{$call->role}}</td>
                                    <td>{{$best->user_count}}</td>
                                    <td>{{$call->code}}</td>

                                    <td>
                                        @if($call->account_status == 'active')
                                            <span class="badge badge-success">Active</span>

                                        @elseif($call->account_status == 'block')
                                            <span class="badge badge-danger">Block</span>

                                        @elseif($call->account_status == 'deactive')
                                            <span class="badge badge-warning">DeActive</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/.col-->





        </div>
        <!--/.row-->
    </main>
@endsection