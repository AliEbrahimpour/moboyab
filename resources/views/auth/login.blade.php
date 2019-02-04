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
                <h2 class="user_unregistered-title">حساب ندارید ؟</h2>
                <p class="user_unregistered-text">
                    با ثبت نام در سایت از مزایای زیادی بهره مند شوید.
                </p>
                <button class="user_unregistered-signup" id="signup-button">
                    نام نویسی
                </button>
            </div>

            <div class="user_options-registered">
                <h2 class="user_registered-title">حساب دارید؟</h2>
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
                            <input name="email" type="email" placeholder="ایمیل" class="forms_field-input" required autofocus />
                        </div>
                        <div class="forms_field">
                            <input name="password" type="password" placeholder="پسورد" class="forms_field-input" required />
                        </div>
                    </fieldset>
                    <div class="forms_buttons">
                        <button type="button" class="forms_buttons-forgot">فراموشی رمز</button>
                        <input type="submit" value="ورود" class="forms_buttons-action">
                    </div>
                </form>
            </div>
            <div class="user_forms-signup">
                <h2 class="forms_title">عضویت</h2>
                <form style="direction: rtl" method="POST" action="{{ route('register') }}">
                    @csrf
                    @include('layouts.errors')
                    <fieldset class="forms_fieldset">
                        <div class="forms_field">
                            <input name="name"  type="text" placeholder="نام" class="forms_field-input" required />
                        </div>
                        <div class="forms_field">
                            <input name="email" type="email" placeholder="ایمیل" class="forms_field-input" required />
                        </div>
                        <div class="forms_field">
                            <input name="password" type="password" placeholder="پسورد" class="forms_field-input" required />
                        </div>
                        <div class="forms_field">
                            <input name="password_confirmation" type="password" placeholder="تکرار پسورد" class="forms_field-input" required />
                        </div>
                    </fieldset>
                    <div class="forms_buttons">
                        <input type="submit" value="ارسال" class="forms_buttons-action">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



<script  src="js/login.js"></script>




</body>

</html>
