@extends('layouts.user_panel')
@section('body')
    <!-- Main content -->
    <main class="main">

        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">میزکار</li>

            <li class="breadcrumb-item active">میزکار</li>

            <!-- Breadcrumb Menu-->
            <li class="breadcrumb-menu d-md-down-none">
                <div class="btn-group" role="group" aria-label="Button group">
                    <a class="btn" href="#"><i class="icon-speech"></i></a>
                    <a class="btn" href="./"><i class="icon-graph"></i> &nbsp;میزکار</a>
                    <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;تنظیمات</a>
                </div>
            </li>
        </ol>

    <div id="app">
        <example-component></example-component>
        <div class="container-fluid">

            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body pb-0">
                                <div class="btn-group float-right">
                                    <button type="button" class="btn btn-transparent dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-settings"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">لینک شماره ۱</a>
                                        <a class="dropdown-item" href="#">لینک شماره ۲</a>
                                        <a class="dropdown-item" href="#">لینک شماره ۳</a>
                                    </div>
                                </div>
                                <h4 class="mb-0">9.823</h4>
                                <p>کاربران آنلاین</p>
                            </div>
                            <div class="chart-wrapper px-3" style="height:70px;">
                                <canvas id="card-chart1" class="chart" height="70"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-info">
                            <div class="card-body pb-0">
                                <button type="button" class="btn btn-transparent p-0 float-right">
                                    <i class="icon-location-pin"></i>
                                </button>
                                <h4 class="mb-0">9.823</h4>
                                <p>کاربران آنلاین</p>
                            </div>
                            <div class="chart-wrapper px-3" style="height:70px;">
                                <canvas id="card-chart2" class="chart" height="70"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body pb-0">
                                <div class="btn-group float-right">
                                    <button type="button" class="btn btn-transparent dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-settings"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">لینک شماره ۱</a>
                                        <a class="dropdown-item" href="#">لینک شماره ۲</a>
                                        <a class="dropdown-item" href="#">لینک شماره ۳</a>
                                    </div>
                                </div>
                                <h4 class="mb-0">9.823</h4>
                                <p>کاربران آنلاین</p>
                            </div>
                            <div class="chart-wrapper" style="height:70px;">
                                <canvas id="card-chart3" class="chart" height="70"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-danger">
                            <div class="card-body pb-0">
                                <div class="btn-group float-right">
                                    <button type="button" class="btn btn-transparent dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-settings"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">لینک شماره ۱</a>
                                        <a class="dropdown-item" href="#">لینک شماره ۲</a>
                                        <a class="dropdown-item" href="#">لینک شماره ۳</a>
                                    </div>
                                </div>
                                <h4 class="mb-0">9.823</h4>
                                <p>کاربران آنلاین</p>
                            </div>
                            <div class="chart-wrapper px-3" style="height:70px;">
                                <canvas id="card-chart4" class="chart" height="70"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->
                </div>
                <!--/.row-->

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h4 class="card-title mb-0">ترافیک سایت</h4>
                                <div class="small text-muted">شهریور ۱۳۹۶</div>
                            </div>
                            <!--/.col-->
                            <div class="col-sm-7 hidden-sm-down">
                                <button type="button" class="btn btn-primary float-left"><i class="icon-cloud-download"></i>
                                </button>
                                <div class="btn-toolbar float-left" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">
                                        <label class="btn btn-outline-secondary">
                                            <input type="radio" name="options" id="option1">روز
                                        </label>
                                        <label class="btn btn-outline-secondary active">
                                            <input type="radio" name="options" id="option2" checked="">ماه
                                        </label>
                                        <label class="btn btn-outline-secondary">
                                            <input type="radio" name="options" id="option3">سال
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--/.col-->
                        </div>
                        <!--/.row-->
                        <div class="chart-wrapper" style="height:300px;margin-top:40px;">
                            <canvas id="main-chart" class="chart" height="300"></canvas>
                        </div>
                    </div>
                    <div class="card-footer">
                        <ul>
                            <li>
                                <div class="text-muted">بازدید ها</div>
                                <strong>29.703 کاربران (40%)</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="hidden-sm-down">
                                <div class="text-muted">بازدید های جدید</div>
                                <strong>24.093 کاربران (20%)</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li>
                                <div class="text-muted">بازدید صفحات</div>
                                <strong>78.706 نمایش ها (60%)</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="hidden-sm-down">
                                <div class="text-muted">کاربران جدید </div>
                                <strong>22.123 کاربران (80%)</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="hidden-sm-down">
                                <div class="text-muted">ضریب بازگست</div>
                                <strong>40.15%</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--/.card-->


            </div>


        </div>
    </div>
        <!-- /.conainer-fluid -->
    </main>
@endsection



