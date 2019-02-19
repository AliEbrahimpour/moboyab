@extends('layouts.user_panel')

@section('body')
    <main class="main">

        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">اعتبار {{auth()->user()->firstname}}:<span
                        class="text-danger">{{auth()->user()->credit}}</span> هزار تومان</h1>
            <h3 style="padding: 30px;">همچنین امتیاز شما برابر است با <span
                        class="text-danger">{{auth()->user()->star}}</span></h3>
        </div>

        <div class="container">
            <div class="card-deck mb-3 text-center">
                <div class="card mb-4 box-shadow">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">کل درآمد ثبت شده</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">{{$accept->sum('amount')+$waiting->sum('amount')}}
                            <small class="text-muted">/ تومان</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li> تعداد کاربران دعوت شده: {{$accept->count()+$waiting->count()}}</li>
                            {{--<li>مطلب تست</li>--}}
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-outline-primary">مشاهده جزییات</button>
                    </div>
                </div>
                <div class="card mb-4 box-shadow">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">درآمد واریز شده</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">
                            {{$accept->sum('amount')}}
                            <small class="text-muted">/ تومان</small>
                        </h1>

                        <ul class="list-unstyled mt-3 mb-4">
                            <li> تعداد کاربران دعوت شده: {{$accept->count()}}</li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-outline-primary">مشاهده جزییات</button>
                    </div>
                </div>
                <div class="card mb-4 box-shadow">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">درآمد در دست بررسی</h4>
                    </div>
                    <div class="card-body">

                        <h1 class="card-title pricing-card-title">{{$waiting->sum('amount')}}
                            <small class="text-muted">/ تومان</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li> تعداد کاربران دعوت شده: {{$waiting->count()}}</li>
                        </ul>
                        <button type="button" data-toggle="modal" data-target="#exampleModal"
                                class="btn btn-lg btn-block btn-outline-success">درخواست پرداخت
                        </button>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">درخواست پرداخت</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h5 class="input-group-text" id="">نام و نام خانوادگی</h5>
                                            </div>
                                            <span aria-hidden="true"></span>
                                            <input placeholder="نام" type="text" class="form-control">
                                            <input placeholder="نام خانوادگی" type="text" class="form-control">
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <h5 class="input-group-text" id="">مبلغ: </h5>
                                            <input placeholder="مبلغ" type="text" class="form-control"
                                                   aria-label="Amount (to the nearest dollar)">
                                            <div class="input-group-append">
                                                <h5 class="input-group-text">تومان</h5>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">بستن
                                        </button>
                                        <button type="button" class="btn btn-outline-success">ذخیره</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </main>
@endsection


