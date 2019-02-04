<!DOCTYPE html>
<html lang="fa" >

<head>
    <meta charset="UTF-8">
    <title>صفحه لاگین و ثبت نام</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300, 400, 500" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="css/login.css">


</head>

<body>



<section class="user">
    <div class="user_options-container">
        <div class="user_options-text">
            <div class="user_options-unregistered">
                <h2 class="user_unregistered-title">تصدیق ورود</h2>
                <p class="user_unregistered-text">
                    لطفا کد ارسالی را وارد نمایید
                </p>
            </div>

            <div class="user_options-registered">
                <p class="user_registered-text">
                    وارد حساب خود شوید و از مزایای سایت استفاده کنید.
                </p>
                <button class="user_registered-login" id="login-button">ورود</button>
            </div>
        </div>

        <div class="user_options-forms" id="user_options-forms">
            <div class="user_forms-login">
                <h2 class="forms_title">ورود</h2>
                <form style="direction: rtl" method="POST" action="{{ route('login') }}">
                    @csrf
                    @include('layouts.errors')
                    <fieldset class="forms_fieldset">
                        <div class="forms_field">
                            <input name="password" type="password" placeholder="کد ارسالی" class="forms_field-input" required />
                        </div>
                    </fieldset>
                    <div class="forms_buttons">
                        <input type="submit" value="ورود" class="forms_buttons-action">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



<script  src="js/login.js"></script>




</body>

</html>
