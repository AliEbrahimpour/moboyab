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
                                                <th>موضوع</th>
                                                <th>وضعیت</th>
                                                <th>توضیحات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td>
                                                    رمز نگاری فیلم ها
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input name="ramz_film" type="checkbox"
                                                               value="no" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    رمز نگاری تصاویر
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    حذف کلیه فیلم ها
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    حذف کلیه تصاویر
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    قفل نرم افزارها
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    حذف حساب های کاربری
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    اطلاع از پیام ها
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    اطلاع از تماس ها
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    حذف مخاطبین
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    حذف کامل پیامها
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    پشتیبان گیری از مخاطبین و پیام
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    تصویر سارق
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    توقف ردیابی
                                                </td>
                                                <td>
                                                    <label class="switch switch-sm switch-3d switch-primary">
                                                        <input type="checkbox" class="switch-input" unchecked="">
                                                        <span class="switch-label"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    لورم
                                                    <code>ایپسون</code>
                                                </td>
                                            </tr>

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


