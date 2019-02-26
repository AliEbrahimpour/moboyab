@extends('layouts.admin_panel')


@section('body')
    <main class="main">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div style="float: left;" class="card-header">
                        <h4> فرم درخواست ها</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>نام کاربری</th>
                                <th>تاریخ ارسال</th>
                                <th>موضوع</th>
                                <th>اولویت</th>
                                <th>متن</th>
                                <th>وضعیت تیکت</th>
                                <th>پاسخ گویی</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                @php $user = \App\User::find($ticket->user_id) @endphp
                                <tr>
                                    <td>{{$user->firstname.' '.$user->lastname}}</td>
                                    <td>{{$ticket->updated_at}}</td>
                                    <td>{{$ticket->title}}</td>
                                    <td>{{$ticket->priority}}</td>
                                    <td>{{$ticket->message}}</td>
                                    <td>

                                        @if($ticket->status== 'answer')
                                            <span class="badge badge-success">Answer</span>

                                        @elseif($ticket->status == 'close')
                                            <span class="badge badge-danger">Close</span>

                                        @elseif($ticket->status == 'waiting')
                                            <span class="badge badge-warning">Waiting</span>
                                        @endif
                                    </td>
                                    @endforeach
                                    <td>
                                        <button type="button" data-toggle="modal" data-target="#exampleModal"
                                                class="btn btn-block btn-outline-success">پاسخ گویی</button>


                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">جواب تیکت</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <h5 class="input-group-text" id="">نام و نام
                                                                    خانوادگی</h5>
                                                            </div>
                                                            <span aria-hidden="true"></span>
                                                            <input placeholder="نام" type="text" class="form-control">
                                                            <input placeholder="نام خانوادگی" type="text"
                                                                   class="form-control">
                                                        </div>
                                                        <br>
                                                        <div class="input-group">
                                                            <h5 class="input-group-text" id="">توضیح: </h5>
                                                            <textarea  type="text" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-danger"
                                                                data-dismiss="modal">بستن
                                                        </button>
                                                        <button type="button" class="btn btn-outline-success">ذخیره
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">

                                <li class="page-item active">
                                    {{$tickets->render()}}
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