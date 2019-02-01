@extends('layouts.admin_panel')
@section('body')
    <main class="main">
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> فرم ثبت نامی ها
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>نام کاربری</th>
                        <th>تاریخ عضویت</th>
                        <th>کد معرف</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Vishnu Serghei</td>
                        <td>2012/01/01</td>
                        <td>Member</td>
                        <td>
                            <span class="badge badge-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Zbyněk Phoibos</td>
                        <td>2012/02/01</td>
                        <td>Staff</td>
                        <td>
                            <span class="badge badge-danger">Banned</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Einar Randall</td>
                        <td>2012/02/01</td>
                        <td>Admin</td>
                        <td>
                            <span class="badge badge-default">Inactive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Félix Troels</td>
                        <td>2012/03/01</td>
                        <td>Member</td>
                        <td>
                            <span class="badge badge-warning">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Aulus Agmundr</td>
                        <td>2012/01/21</td>
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