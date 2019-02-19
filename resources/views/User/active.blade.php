@extends('layouts.user_panel')

@section('body')
    <main class="main">

    <div class="card">
    <div class="card-header">
        <i class="fa fa-align-justify"></i> لیست فعالیت ها
    </div>
    <div class="card-body">
        <div id="accordion" role="tablist">
            @php $i=0 @endphp
    @foreach($events as $event)
            <div class="card mb-0">
                <div class="card-header" id="headingOne" role="tab">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" href="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne">لیست فعالیت های شماره {{$i +=1}}</a>
                    </h5>
                </div>
                <div class="collapse show" id="collapseOne" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام دستور</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">اخرین تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{\App\Action::find($event->action_id)->name}}</td>
                                <td>{{$event->status}}</td>
                                <td>{{$event->updated_at}}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
    @endforeach
        </div>
    </div>
</div>
    </main>
@endsection