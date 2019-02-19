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
                                    <td>{{$caller->caller_id}}</td>
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
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> کاربران فعال
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>نام کاربری</th>
                                <th>تعداد عضویت</th>
                                <th>کد معرف</th>
                                <th>وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Vishnu Serghei</td>
                                <td>20</td>
                                <td>Member</td>
                                <td>
                                    <span class="badge badge-success">Active</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Zbyněk Phoibos</td>
                                <td>30</td>
                                <td>Staff</td>
                                <td>
                                    <span class="badge badge-danger">Banned</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Einar Randall</td>
                                <td>15</td>
                                <td>Admin</td>
                                <td>
                                    <span class="badge badge-default">Inactive</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Félix Troels</td>
                                <td>40</td>
                                <td>Member</td>
                                <td>
                                    <span class="badge badge-warning">Pending</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Aulus Agmundr</td>
                                <td>50</td>
                                <td>Staff</td>
                                <td>
                                    <span class="badge badge-success">Active</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Prev</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">4</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>کنترل از راه دور
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>نام دستور</th>
                                <th>تعداد استفاده</th>
                                <th>تعداد موفق</th>
                                <th>تعداد ناموفق</th>
                                <th>جزییات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Vishnu Serghei</td>
                                <td>20</td>
                                <td>20</td>
                                <td>20</td>
                                <td>
                                    <button class="btn btn-block">مشاهده جزییات</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Zbyněk Phoibos</td>
                                <td>30</td>
                                <td>30</td>
                                <td>30</td>
                                <td>
                                    <button class="btn btn-block">مشاهده جزییات</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Einar Randall</td>
                                <td>15</td>
                                <td>15</td>
                                <td>15</td>
                                <td>
                                    <button class="btn btn-block">مشاهده جزییات</button>

                                </td>
                            </tr>
                            <tr>
                                <td>Félix Troels</td>
                                <td>40</td>
                                <td>40</td>
                                <td>40</td>
                                <td>
                                    <button class="btn btn-block">مشاهده جزییات</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Aulus Agmundr</td>
                                <td>50</td>
                                <td>50</td>
                                <td>50</td>
                                <td>
                                    <button class="btn btn-block">مشاهده جزییات</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Prev</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">4</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--/.col-->


        </div>
        <!--/.row-->
    </main>
@endsection