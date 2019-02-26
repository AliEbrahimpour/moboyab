<?php

namespace App\Http\Controllers;

use App\Classes\FcmClass;
use App\Classes\GlobalClass;
use App\Classes\Keys;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests;
use App\Models\Action;
use App\Models\Active_code;
use App\Models\Apps;
use App\Models\BackupMessages;
use App\Models\Call;
use App\Models\DeviceId;
use App\Models\Event;
use App\Models\InvitedUser;
use App\Models\Location;
use App\Models\News;
use App\Models\Pay;
use App\Models\Plans;
use App\Models\Receive_sms;
use App\Models\Sim;
use App\Models\Sms;
use App\Models\Thief_image;
use App\Models\User;
use App\Models\UserWallet;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Validator;

class ApiController extends Controller
{
    public static function sendOneRequest(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            $targetUser = $request->target_username;
            $targetPass = $request->target_pass;
            $comments = $request->comments;
            $commentId = $request->comment_id;
            $api = $request->has('api');
            if ($username != null && $targetUser != null &&
                ($targetPass != null or $api) && $comments != null && $commentId != null
            ) {
                $user = User::where('username', $username)->first();
                if ($user) {
                    if ($user->user_status == Keys::ACTIVATED and ($user->pay or $user->expire_test_plan > Carbon::now())) {
                        $TUser = User::where('username', $targetUser)->first();
                        if ($TUser) {
                            if ($comments != 'd') {
                                if (Hash::check($targetPass, $TUser->password) or $api) {
//                                    if (GlobalClass::checkUseCommand($comments, $TUser->id)) {
                                    $eventIds = '';
                                    $escCommands = '';
                                    $sendCommand = '';
                                    foreach (explode(',', $comments) as $index => $item) {
                                        if (GlobalClass::checkUseCommand($item, $TUser->id)) {
                                            $event = new Event();
                                            $event->user_target_id = $user->id;
                                            $event->user_id = $TUser->id;
                                            $event->action_id = Action::where(Keys::CODE, (string)$item)->first()->id;
                                            $event->command_id = $commentId;
                                            $event->status = Keys::SMS_STATUS_NOT_SEND;
                                            $event->save();
                                            $eventIds .= $event->id . ',';
                                            $sendCommand .= $item . ',';
                                        } else $escCommands .= $item . ',';
                                    }
                                    if ($eventIds != '') {
                                        $eventIds = str_replace_last(',', '', $eventIds);
                                        $sendCommand = str_replace_last(',', '', $sendCommand);
                                        $msg = self::sendSMSCommentsCode($TUser->active_number, $eventIds, $sendCommand, false, $username);

                                        if ($msg['status']) {
                                            if ($msg['value']) {

                                                foreach (explode(',', $eventIds) as $index => $item) {
                                                    $event = Event::find($item);
                                                    if ($event) {
                                                        $event->status_number = $msg['value'];
                                                        $event->status = Keys::SMS_STATUS_SEND;
                                                        $event->save();
                                                    }
                                                }
                                                foreach (explode(',', $escCommands) as $index => $item) {
                                                    $event = Event::find($item);
                                                    if ($event) {
                                                        $event->status = Keys::EVENT_FAILED;
                                                        $event->save();
                                                    }
                                                }
                                                $message = 'درخواست به گوشی مقصد با موفقیت ارسال شد.';
                                                $status = true;
                                                $value = json_decode('{"action":"' . 'send_success' . '","event_ids":"' . $eventIds . '","esc_ids":"' . $escCommands . '"}');

                                            } else {
                                                $event->status = Keys::SMS_STATUS_NOT_SEND;
                                                $message = 'کاربر مورد نظر فعال نیست!';
                                                $status = false;
                                            }
                                        } else {
//                                            $pay = GlobalClass::checkUserPlan($TUser->id);
                                            foreach (explode(',', $eventIds) as $index => $item) {
                                                $event = Event::find($item);
                                                if ($event) {
                                                    $event->status = Keys::SMS_STATUS_NOT_SEND;
                                                    $event->save();
                                                }
//                                                $payed = $pay->count;
//                                                $pay->count -= Action::find($item)->cost;
//                                                $pay->save();
                                            }
                                            $message = 'خطایی در سامانه رخ داد،لطفا مجددا تلاش کنید!';
                                            $status = false;
                                            $value = json_decode('{"action":"failed"}');
                                        }

                                    } else {
                                        $message = 'کاربر مورد نظر فعال نیست!';
                                        $status = false;
                                    }
//                                    }
                                } else {
                                    $message = 'اطلاعات حساب کاربری اشتباه است!';
                                    $status = false;
                                }
                            } else {
                                if (GlobalClass::checkUseCommand('d', $TUser->id)) {
                                    $event = new Event();
                                    $event->user_id = $user->id;
                                    $event->user_target_id = $TUser->id;
                                    $event->action_id = Action::where(Keys::CODE, (string)'d')->first()->id;
                                    $event->command_id = $commentId;
                                    $event->status = Keys::SMS_STATUS_NO_ACTION;
                                    $msg = ApiController::sendSMSCommentsCode($TUser->active_number, $event->id, $comments, true, $username);

                                    if ($msg['status']) {
                                        if ($msg['value']) {
                                            $event->status_number = $msg['value'];
                                            $message = 'درخواست به گوشی مقصد با موفقیت ارسال شد.';
                                            $status = true;
                                            $value = json_decode('{"action":"' . 'send_success' . '","sender":"' . $username . '"}');
                                            $event->status = Keys::SMS_STATUS_SEND;
                                        } else {
                                            $event->status = Keys::SMS_STATUS_NOT_SEND;
                                            $message = 'کاربر مورد نظر فعال نیست!';
                                            $status = false;
                                        }
                                    } else {
                                        $event->status = Keys::SMS_STATUS_NOT_SEND;
                                        $message = 'خطایی در سامانه رخ داد،لطفا مجددا تلاش کنید!';
                                        $status = false;
                                        $value = json_decode('{"action":"failed"}');
                                    }
                                    $event->save();
                                } else {
                                    $message = 'کاربر مورد نظر فعال نیست!';
                                    $status = false;
                                }
                            }
                        } else {
                            $message = 'اطلاعات حساب کاربری اشتباه است!';
                            $status = false;
                        }
                    } else {
                        $status = false;
                        switch ($user->user_status) {
                            default:
                                $message = ' مدت اعتبار تست شما به اتمام رسیده است.';
                                break;
                            case Keys::BLOCK:
                            case Keys::NO_ACTIVE:
                                $message = 'حساب کاربری شما مسدود است. لطفا از طریق پشتیبانی پیگیری نمایید';
                                break;
                        }
                    }
                } else {
                    $message = 'نام کاربری شما اشتباه است!';
                    $status = false;
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public static function sendSMSCommentsCode($username, $eventsId, $comments, $action, $user)
    {
        try {
            $myGlobal = new GlobalClass;
            $ids = '';
            $Eids = explode(',', $eventsId);
            $i = 0;
            foreach (explode(',', $comments) as $index => $item) {
                if ($item == '0' or $item == '7' or $item == '8' or $item == 'c' or $item == 'd')
                    $ids .= $Eids[$i] . ',';
                else
                    $ids .= ' ,';
                $i++;
            }
            if ($action) {
                $text = 'i-' . $ids . '-' . $comments . '-' . $user;
            } else
                $text = 'i-' . $ids . '-' . $comments;
            return $myGlobal->sendSMS($username, $text);
        } catch (\Exception $message) {
            return [
                'status' => false,
                'message' => $message->getMessage(),
                'value' => 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode()
            ];
        }
    }

    public static function addDeviceId(Request $request)
    {
        try {
            $message = '';
            $value = '{}';
            $status = false;
            $rules = array(
                'device_id' => 'required',
                'reg_id' => 'required',
                'user_id' => 'required',
            );
            $validator = validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $message = $validator->errors()->first();
                $status = false;
            } else {
                $user = User::where('id', $request->get('user_id'))->get();
                $reg_id = $request->get('reg_id');
                $device_id = $request->get('device_id');
                if ($user->count() != 0) {
                    if (!DeviceId::where('user_id', $request->get('user_id'))->where('reg_id', $reg_id)->where('device_id', $device_id)->first()) {
                        $device = new DeviceId();
                        $device->device_id = $device_id;
                        $device->reg_id = $reg_id;
                        $device->user_id = $request->get('user_id');
                        $device->save();
                        $message = 'دستگاه با موفقیت ثبت شد.';
                        $value = '{}';
                        $status = true;
                        $user = $user->first();
                        $user->device_id = $device_id;
                        $user->save();
                    } else {
                        $message = 'این دستگاه قبلا ثبت شده است.';
                        $value = '{}';
                        $status = false;
                    }
                } else {
                    $message = 'نام کاربری اشتباه است.';
                    $value = '{}';
                    $status = false;
                }
            }
        } catch (\Exception $e) {
            $message = 'error : msg->' . $e->getMessage() . ' line->' . $e->getLine() . ' code->' . $e->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];

    }

    public function login(Request $request)
    {
        $message = '';
        try {
            $username = $request->username;
            $deviceId = $request->device_id;
            $password = $request->password;
            if ($username != null && $deviceId != null && $password != null) {
                $rand = rand(1111, 9999);
                $user = User::where(Keys::USERNAME, $username)->first();

                if ($user) {
                    if (Hash::check($password, $user->password)) {
                        Active_code::destroy(Active_code::where(Keys::USER_ID, (string)$user->id)->pluck('id'));
                        if (($user->device_id == $deviceId or $user->device_id == null)) {
                            switch ($user->user_status) {
                                case Keys::NO_ACTIVE:
                                    $status = true;
                                    $_activeCode = new Active_code();
                                    $_activeCode->active_code = Hash::make($rand);
                                    $_activeCode->user_id = $user->id;
                                    $_activeCode->save();
                                    $user->device_id = $deviceId;
                                    $user->save();
                                    $user->active()->save($_activeCode);
                                    $value = $user;
                                    break;
                                case Keys::BLOCK:
                                    $status = false;
                                    $message = 'حساب کاربری شما مسدود است!';
                                    $value = $user;
                                    break;
                                default:
                                    $status = true;
                                    $user->device_id = $deviceId;
                                    $user->save();
                                    if (!$token = auth('api')->attempt(array('username' => $username, 'password' => $password))) {
                                        $status = false;
                                        $message = 'خطا در ساخت توکن';
                                        break;
                                    }

                                    $user['token'] = $token;
                                    $value = $user;
                                    break;
                            }
//                            return $user;
                        } else {
                            $status = false;
                            $message = 'این شماره در دستگاه دیگری ثبت است.';
                            $value = json_decode('{}');
                        }
                    } else {
                        $message = 'اطلاعات ورود اشتباه است.';
                        $value = json_decode('{}');
                        $status = false;
                    }
                } else {
                    $message = 'اطلاعات ورود اشتباه است.';
                    $value = json_decode('{}');
                    $status = false;
                }

            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{}');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{}');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function register(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        $smsSend = false;
        try {
            $username = $request->username;
            $deviceId = $request->device_id;
            $password = $request->password;
            $inviteCode = $request->invite_code;
            if ($username != null && $deviceId != null && $password != null) {
                $rand = rand(1111, 9999);
                $user = User::where(Keys::USERNAME, $username)->first();

                if ($user) {
                    $message = 'این شماره قبلا در سیستم ثبت شده است.';
                    $value = json_decode('{}');
                    $status = false;
                } else {
                    $data = array(
                        'username' => $username,
                        'password' => $password,
                        'checkbox' => 'true',
                        'invite_code' => $inviteCode,
                    );
                    $registerStatus = RegisterController::apiRegister($data, true);
                    if ($registerStatus['status']) {
                        $_user = $registerStatus['value'];
                        $_user->device_id = $deviceId;
                        $_user->user_status = Keys::NO_ACTIVE;
                        $_user->save();

                        $_activeCode = new Active_code();
                        $_activeCode->active_code = Hash::make($rand);
                        $_activeCode->user_id = $_user->id;
                        $_activeCode->save();
                        $_user->active()->save($_activeCode);
                        $user = $_user;
                        $status = true;
                        $message = $registerStatus['message'];
                        $smsSend = true;

                    } else {
                        $status = false;
                        $message = $registerStatus['message'];
                    }
                }

                if ($smsSend) {
                    $smsStatus = $this->sendSMSActiveCode($user, $rand);
                    if ($smsStatus['status']) {
                        $status = true;
                        $message = 'کدفعال سازی برای شما ارسال شد لطفا از طریق آن اقدام به فعال سازی موبویاب کنید.';
                        $value = array(
                            'action' => 'send_sms',
                            'user' => $user
                        );
                    } else {
                        $status = false;
                        $value = json_decode('{"action":"failed","value":"' . $smsStatus['value'] . '"}');
                        $message = $smsStatus['message'];
                    }
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{}');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{}');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function sendSMSActiveCode($user, $activeCode)
    {
        try {
            $myGlobal = new GlobalClass;
            $text = 'برای فعال سازی حساب موبویاب از کد زیر استفاده کنید.' . "\n" .
                $activeCode . "\n" . ' moboyab.ir';
            return $myGlobal->sendSMS($user['username'], $text);

//            switch ($msg) {
//                case 0:
////                    echo "نام کاربری یا رمز عبور اشتباه می باشد" . "<br />";
//                    return false;
//                    break;
//
//                case 1:
////                    echo "درخواست با موفقیت انجام شد" . "<br />";
//                    return true;
//                    break;
//
//                case 2:
////                    echo "اعتبار کافی نمی باشد" . "<br />";
//                    return false;
//                    break;
//
//                case 3:
////                    echo "محدودیت در ارسال روزانه" . "<br />";
//                    return false;
//                    break;
//
//                case 4:
////                    echo "محدودیت در حجم ارسال" . "<br />";
//                    return false;
//                    break;
//
//                case 5:
////                    echo "شماره فرستنده معتبر نمی باشد" . "<br />";
//                    return false;
//                    break;
//
//                case 6:
////                    echo "سامانه در حال بروزرسانی می باشد" . "<br />";
//                    break;
//
//                case 7:
////                    echo "متن حاوی کلمه فیلتر شده می باشد" . "<br />";
//                    return false;
//                    break;
//
//                case 9:
////                    echo "ارسال از خطوط عمومی از طریق وب سرویس امکان پذیر نمی باشد" . "<br />";
//                    return false;
//                    break;
//
//                case 10:
////                    echo "کاربر مورد نظر فعال نمی باشد" . "<br />";
//                    return false;
//                    break;
//
//                case 11:
////                    echo "ارسال نشده" . "<br />";
//                    return false;
//                    break;
//
//                case 12:
////                    echo "مدارک کاربر کامل نمی باشد" . "<br />";
//                    return false;
//                    break;
//                default:
//                    return true;
//            }
        } catch (\Exception $message) {
//            echo 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            return false;
        }
    }

    public function activation(Request $request)
    {
        $message = '';
        $value = json_decode('{}');
        $status = false;
        $newUser = 'new';
        $username = $request->username;
        $password = $request->password;
        try {
            $_active_code = Active_code::where(Keys::USER_ID, (string)User::where(Keys::USERNAME, $username)->first()->id)->first();
            if ($_active_code and Hash::check($request->code, $_active_code->active_code)) {
                $_active_code->delete();
                $user = User::where(Keys::USERNAME, $username)->first();
                if (Hash::check($password, $user->password)) {
                    $message = 'حساب کاربری با موفقیت فعال شد!';
                    $status = true;
                    $user->user_status = Keys::ACTIVATED;
                    $user->status = 1;
                    $user->active_number = $username;
                    $user->save();
                    if (!$token = auth('api')->attempt(array('username' => $username, 'password' => $password))) {
                        $status = false;
                        $message = 'خطا در ساخت توکن';
                    } else {
                        $user['token'] = $token;
                        $value = [
                            "action" => "active",
                            "user" => $user,
                        ];
                    }

                } else {
                    $message = 'پسورد اشتباره است';
                }

//                $value = json_decode('{,. ' . '"}');
            } else {
                $message = 'کد فعال سازی اشتباه است!';
                $status = false;
            }
        } catch (\Exception $message) {
            echo 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $status = false;
            $message = 'حساب کاربری وجود ندارد' . ' یا فعال است.';
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function resetActiveCode(Request $request)
    {
        $message = '';
        $value = json_decode('{}');
        $status = false;
        try {
            $username = $request->username;
            $_user = User::where(Keys::USERNAME, $username)->first();

            Active_code::destroy(Active_code::where(Keys::USER_ID, (string)$_user->id)->pluck('id'));

            if ($_user->user_status != Keys::BLOCK) {
                $_activeCode = new Active_code();
                $rand = rand(1111, 9999);
                $_activeCode->user_id = $_user->id;
                $_activeCode->active_code = Hash::make($rand);
                $_activeCode->status_number = true;
                $_activeCode->save();
                $_user->active()->save($_activeCode);


                $smsStatus = $this->sendSMSActiveCode($_user, $rand);
                if ($smsStatus['status']) {
                    $status = true;
                    $message = 'کدفعال سازی ارسال شد.';
                    $value = json_decode('{"action":"send_sms"}');
                } else {
                    $status = false;
                    $value = json_decode('{"action":"failed","value":"' . $smsStatus['value'] . '"}');
                    $message = $smsStatus['message'];
                }

            } else {
                $status = false;
                $message = 'حساب کاربری مسدود است.';
                $value = json_decode('{"action":"not_send_sms"}');
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function sendRequest(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            $targetUser = $request->target_username;
            $targetPass = $request->target_pass;
            $comments = $request->comments;
            $commentId = $request->comment_id;
            $globalClass = new GlobalClass();
            if ($username != null && $targetUser != null &&
                $targetPass != null && $comments != null && $commentId != null
            ) {
                $user = User::where('username', $username)->get();
                if ($user) {
                    if ($user->first()->status) {
                        $TUser = User::where('username', $targetUser)->get();
                        if ($TUser->count()) {
                            if ($comments != 'd') {
                                if (Hash::check($targetPass, $TUser->first()->password)) {
                                    if ($TUser->first()->pay == 'true') {
                                        $eventIds = '';
                                        foreach (explode(',', $comments) as $index => $item) {
                                            $event = new Event();
                                            $event->user_target_id = $user->first()->id;
                                            $event->user_id = $TUser->first()->id;
                                            $event->action_id = Action::where(Keys::CODE, (string)$item)->first()->id;
                                            $event->command_id = $commentId;
                                            $event->status = Keys::SMS_STATUS_NO_ACTION;
                                            $event->save();
                                            $eventIds .= $event->id . ',';
                                        }
                                        if ($eventIds != '') {
                                            $eventIds = str_replace_last(',', '', $eventIds);
                                            $msg = $this->sendSMSCommentsCode($TUser->first()->active_number, $eventIds, $comments, false, $username);
                                            foreach (explode(',', $eventIds) as $index => $item) {
                                                $event = Event::find($item);
                                                $event->status_number = $msg;
                                                $event->save();
                                            }
                                            if (strlen($msg) > 5) {
                                                $message = 'درخواست به گوشی مقصد با موفقیت ارسال شد.';
                                                $status = true;
                                                $value = json_decode('{"action":"' . $msg . '","event_ids":"' . $eventIds . '"}');
                                            } else {
                                                $message = 'خطایی در سامانه رخ داد،لطفا مجددا تلاش کنید!';
                                                $status = false;
                                                $value = json_decode('{"action":"failed"}');
                                            }
                                        }
                                    } else {
                                        $message = 'کاربر مورد نظر هزینه ی فعال سازی را پرداخت نکرده است!';
                                        $status = false;
                                    }
                                } else {
                                    $message = 'گذرواژه اشتباه است!';
                                    $status = false;
                                }
                            } else {
                                if ($TUser->first()->pay == 'true') {
                                    $event = new Event();
                                    $event->user_id = $user->first()->id;
                                    $event->user_target_id = $TUser->first()->id;
                                    $event->action_id = Action::where(Keys::CODE, (string)'d')->first()->id;
                                    $event->command_id = $commentId;
                                    $event->status = Keys::SMS_STATUS_NO_ACTION;
                                    $event->save();
                                    $msg = $this->sendSMSCommentsCode($TUser->first()->active_number, $event->id, $comments, true, $username);
                                    $event->status_number = $msg;
                                    $event->save();
                                    //todo pp
                                    if ($msg->status) {
                                        $message = 'درخواست به گوشی مقصد با موفقیت ارسال شد.';
                                        $status = true;
                                        $value = json_decode('{"action":"' . $msg . '","sender":"' . $username . '"}');
                                    } else {
                                        $message = $msg->message;
                                        $status = false;
                                        $value = json_decode('{"action":"' . $msg->value . '"}');
                                    }
                                } else {
                                    $message = 'کاربر مورد نظر هزینه ی فعال سازی را پرداخت نکرده است!';
                                    $status = false;
                                }
                            }
                        } else {
                            $message = 'نام کاربری دستگاه مقصد اشتباه است!';
                            $status = false;
                        }
                    } else {
                        $status = false;
                        switch ($user->first()->status) {
                            default:
                                $message = 'حساب کاربری شما مسدود است.';
                                break;
                            case Keys::NO_ACTIVE:
                                $message = 'حساب کاربری شما فعال نیست.';
                                break;
                        }
                    }
                } else {
                    $message = 'نام کاربری شما اشتباه است!';
                    $status = false;
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function changePass(Request $request)
    {
        $message = '';
        $value = json_decode('{}');
        $status = false;
        try {
            $username = $request->username;
            $oldPass = $request->old_pass;
            $newPass = $request->new_pass;
            if ($username != null && $oldPass != null && $newPass != null) {
                $user = User::where('username', $username);
                if ($user->count() > 0) {
                    if (Hash::check($oldPass, $user->first()->password)) {
                        $user->first()->password = Hash::make($newPass);
                        $user->first()->save();
                        $message = 'گذرواژه با موفقیت تغییر کرد.';
                        $status = true;
                    } else {
                        $message = 'گذرواژه قبلی اشتباه است!';
                        $status = false;
                    }
                } else {
                    $message = 'نام کاربری اشتباه است!';
                    $status = false;
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function newPass(Request $request)
    {
        $message = '';
        $value = json_decode('{}');
        $status = false;
        try {
            $username = $request->username;
            $newPass = $request->pass;
            if ($username != null && $newPass != null) {
                if (strlen($newPass) < 6) {
                    $message = 'طول گذرواژه حداقل باید 6 کارکتر لاتین باشد.';
                    $value = json_decode('{ }');
                    $status = false;
                }
                $user = User::where('username', $username);
                if ($user->count() > 0) {
                    $user->first()->password = Hash::make($newPass);
                    $user->first()->save();
                    $message = 'گذرواژه با موفقیت تغییر کرد.';
                    $status = true;
                } else {
                    $message = 'نام کاربری اشتباه است!';
                    $status = false;
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function getDelivery(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $delivery_id = $request->delivery_id;
            if ($delivery_id != null) {
                $myGlobal = new GlobalClass;
                $msg = $myGlobal->getSmsStatus($delivery_id);
                $value = json_decode('{"action":"' . $msg . '"}');

            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{}');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{}');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function getClientSMS(Request $request)
    {
        try {
            $get_sms = new Receive_sms();
            $to = $request->to;
            $body = $request->body;
            $from = $request->from;
            $get_sms->body = $body;
            $get_sms->from = $from;
            $get_sms->to = $to;
            $get_sms->save();

            if (strlen($from) == 10)
                $from = '0' . $from;
            if (strlen($to) == 10)
                $to = '0' . $to;
            else if (strlen($to) > 11)
                $to = '09365617902';/*env('SMS_PANEL_NUMBER');*/
            $comment = explode('-', $body);
            switch (strtolower($comment[0])) {
                case 'ia':
                    $location = new Location();
                    $user = User::where('active_number', (string)$to)->first();
                    $location->to = $user->id;
                    $user = User::where('active_number', (string)$from)->first();
                    $location->from = (string)$user->id;
                    $location->event_id = $comment[1];
                    $location->x = $comment[2];
                    $location->y = $comment[3];
                    $location->mcc = $comment[4];
                    $location->cid = $comment[5];
                    $location->lat = $comment[6];
                    $location->save();
                    break;
                case 'ml':
                    $location = new Location();
                    $event = Event::where(Keys::ID, (int)$comment[1])->first();
                    $userId = $event->user_id;
                    $targetUser = User::where(Keys::ID, (int)$userId)->first();
                    $location->to = $userId;
                    $user = User::where(Keys::USERNAME, $from)->first();
                    $location->from = $user->id;
                    $location->event_id = $comment[1];
                    $location->x = $comment[2];
                    $location->y = $comment[3];
                    $location->mcc = $comment[4];
                    $location->cid = $comment[5];
                    $location->lat = $comment[6];
                    $location->save();
                    $msg = $this->sendSMSLocation($user, $targetUser, $location);
                    break;
                case 'ks':
                    $sms = new Sms();
                    $userId = User::where('active_number', (string)$from)->first()->id;
                    $sms->user_id = $userId;
                    $sms->device_id = $comment[1];
                    $sms->body = $comment[2];
                    $sms->number = $comment[3];
                    $sms->type = $comment[4];
                    $sms->date = $comment[5];
                    $sms->save();
                    break;
                case 'kc':
                    $call = new Call();
                    $userId = User::where('active_number', $from)->first()->id;
                    $call->user_id = $userId;
                    $call->device_id = $comment[1];
                    $call->number = $comment[2];
                    $call->type = $comment[3];
                    $call->date = $comment[4];
                    $call->save();
                    break;
                case 'ch':
                    $sim = new Sim();
                    $user = User::where(Keys::USERNAME, $comment[1])->first();
                    $sim->user_id = $user->id;
                    $sim->number = $from;
                    $sim->save();
                    $user->active_number = $from;
                    $user->save();
                    break;
            }
            return '1';
        } catch (\Exception  $message) {
            $get_sms->message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $get_sms->save();
            return 1;
        }
    }

    public function sendSMSLocation($user, $targetUser, $location)
    {
        try {
            $myGlobal = new GlobalClass;
            $text = 'ml-' . $user->username . '-' . $location->x
                . '-' . $location->y
                . '-' . $location->mcc
                . '-' . $location->cid
                . '-' . $location->lat;
            $msg = $myGlobal->sendSMS($targetUser->active_number, $text);
        } catch (\Exception $message) {
            echo 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            return '0';
        }
        return $msg;
    }

    public function getLocation(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $eventId = $request->event_id;
            if ($eventId != null) {
                $myLocation = Location::where('event_id', $eventId);
                if ($myLocation->count() > 0) {
                    $message = '';
                    $value = json_decode('{"x":"' . $myLocation->first()->x .
                        '","y":"' . $myLocation->first()->y .
                        '","mcc":"' . $myLocation->first()->mcc .
                        '","cid":"' . $myLocation->first()->cid .
                        '","lat":"' . $myLocation->first()->lat .
                        '"}');
                    $status = true;
                } else {
                    $message = 'مکان یابی مورد نظر ثبت نشده است';
                    $value = json_decode('{ }');
                    $status = false;
                }

            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function sendLocation(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            $targetUser = $request->target_username;
            $x = $request->x;
            $y = $request->y;
            $mcc = $request->mcc;
            $cid = $request->cid;
            $lac = $request->lac;
            $commandId = $request->command_id;
            if ($username != null && $targetUser != null &&
                $x != null && $y != null && $mcc != null && $cid != null && $lac != null
            ) {
                $user = User::where('username', $username)->first();
                if ($user) {
                    $globalClass = new GlobalClass();
                    switch ($globalClass->checkUserStatus($user->id)) {
                        default:
                            if (GlobalClass::checkUserPlan($user->id)) {
                                $TUser = User::where('username', $targetUser);
                                if ($TUser->count() > 0) {
                                    $event = new Event();
                                    if ($commandId == null) {
                                        $event->user_id = $user->id;
                                        $event->user_target_id = $TUser->first()->id;
                                        $event->action_id = Action::where(Keys::CODE, 'e')->first()->id;
                                        $event->command_id = '-1';
                                        $event->status = Keys::SMS_STATUS_NO_ACTION;
                                        $event->save();
                                    }
                                    $location = new Location();
                                    $targetUser = $TUser->first();
                                    $location->to = (string)$user->id;
                                    $location->from = (string)$TUser->first()->id;
                                    $location->event_id = $commandId == null ? (string)$event->id : $commandId;
                                    $location->x = $x;
                                    $location->y = $y;
                                    $location->mcc = $mcc;
                                    $location->cid = $cid;
                                    $location->lat = $lac;
                                    $location->save();
                                    $msg = $this->sendSMSLocation($user, $TUser->first(), $location);

                                    if ($msg['status']) {
                                        if ($msg['value']) {
                                            $event->status_number = $msg['value'];
                                            $message = 'درخواست به گوشی مقصد با موفقیت ارسال شد.';
                                            $status = true;
                                            $value = json_decode('{"action":"' . 'send_success' . '","sender":"' . $username . '"}');
                                            $event->status = Keys::SMS_STATUS_SEND;
                                        } else {
                                            $event->status = Keys::SMS_STATUS_NOT_SEND;
                                            $message = 'کاربر مورد نظر فعال نیست!';
                                            $status = false;
                                        }
                                    } else {
                                        $event->status = Keys::SMS_STATUS_NOT_SEND;
                                        $message = 'خطایی در سامانه رخ داد،لطفا مجددا تلاش کنید!';
                                        $status = false;
                                        $value = json_decode('{"action":"failed"}');
                                    }
                                    $event->save();

                                } else {
                                    $message = 'نام کاربری دستگاه مقصد اشتباه است!';
                                    $status = false;
                                }

                            } else {
                                $message = 'هزینه فعال سازی پرداخت نشده است.';
                                $status = false;
                            }
                            break;
                        case Keys::NO_ACTIVE:
                            $message = 'حساب کاربری شما فعال نیست.';
                            break;
                        case Keys::BLOCK:
                            $message = 'حساب کاربری شما مسدود است.';
                            break;
                    }
                } else {
                    $message = 'اطلاعات کاربری اشتباه است!';
                    $status = false;
                }

            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function uploadImage(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            $date = $request->date;
            $file = $request->file('photo');
            if ($username != null and $date != null and $request->hasFile('photo')) {
                if ($file->isValid()) {
                    $user = User::where(Keys::USERNAME, $username);
                    if ($user->count() > 0) {
                        $userId = $user->first()->id;
                        $count = Jalalian::now();
                        $global = new GlobalClass();
                        $hashId = $global->hashUrl($userId);
                        $hashCount = $global->hashUrl($count);
                        $file->move(Keys::ROOT_UPLOAD . '/' . $hashId,
                            $hashCount . '.jpg');
                        $image = new Thief_image();
                        $image->user_id = $userId;
                        $image->date = $date;
                        $image->file_name = $hashCount;
                        $image->save();
                        $message = 'تصویر با موفقیت ثبت شد.';
                        $value = json_decode('{ }');
                        $status = true;
                    } else {
                        $message = 'نام کاربری اشتباه است.';
                        $value = json_decode('{ }');
                        $status = false;
                    }
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function setBackupNumber(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            $backup = $request->backup;
            if ($username != null && $backup != null) {
                $user = User::where('username', $username);
                if ($user->count() > 0) {
                    $user->first()->backup_number = $backup;
                    $user->first()->save();
                    $message = 'شماره پشتیبان با موفقیت تعیین شد.';
                    $status = true;
                } else {
                    $message = 'نام کاربری شما اشتباه است!';
                    $status = false;
                }

            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function forgetPass(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            if ($username != null) {
                $user = User::where('username', $username)->first();
                if ($user) {
                    $randPass = rand(1111, 9999);
                    $myGlobal = new GlobalClass;
                    $text = 'گذرواژه جدید حساب موبویاب ' . "\n" .
                        $randPass . "\n" . ' moboyab.ir';
                    $msg = $myGlobal->sendSMS($user->backup_number, $text);

                    if ($msg['status']) {
                        if ($msg['value']) {
                            $message = 'رمز جدید برای شماره پشتیبان ارسال شد!';
                            $status = true;
                            $value = json_decode('{"action":"' . 'send_success' . '","receiver":"' . $user->backup_number . '"}');
                        } else {
                            $message = 'خطایی در سامانه رخ داد،لطفا مجددا تلاش کنید!';
                            $status = false;
                        }
                    } else {
                        $message = 'خطایی در سامانه رخ داد،لطفا مجددا تلاش کنید!';
                        $status = false;
                        $value = json_decode('{"action":"failed"}');
                    }
                } else {
                    $message = 'نام کاربری شما اشتباه است!';
                    $status = false;
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function checkUpdate(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $versionCode = $request->version_code;
            if ($versionCode != null) {
                $last = Apps::max('version_code');
                if ($last > $versionCode) {
                    $app = Apps::where('version_code', $last)->first();
                    $app->count = ($app->count) + 1;
                    $app->save();
                    $status = true;
                    $message = 'نسخه جدید موبویاب در دسترس هست.';
                    $value = json_decode('{ "link" : "' . $app->link . '", "app" : ' . $app . ' }');
                } else {
                    $message = 'شما آخرین نسخه موبویاب را دارید.';
                    $status = false;
                    $value = json_decode('{ "link" : "" }');
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{ }');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function getFactor(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            $deviceId = $request->device_id;
            $password = $request->password;
            if ($username != null && $deviceId != null && $password != null) {
                $user = User::where(Keys::USERNAME, $username)->where('device_id', $deviceId)->first();
                if ($user) {
                    if (Hash::check($password, $user->password)) {
                        $value = [
                            'app' => Apps::latest('version_code')->get()->first(),
                            'invite' => count(InvitedUser::where('user_id', $user->id)->get()),
                        ];
                        $status = true;
                    } else {
                        $message = 'اطلاعات ورود اشتباه است.';
                        $value = json_decode('{}');
                        $status = false;
                    }
                } else {
                    $message = 'اطلاعات ورود اشتباه است.';
                    $value = json_decode('{ }');
                    $status = false;
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{}');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function getDashboard(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $username = $request->username;
            $deviceId = $request->device_id;
            $password = $request->password;
            if ($username != null && $deviceId != null && $password != null) {
                $user = User::where(Keys::USERNAME, $username)->where('device_id', $deviceId)->first();
                if ($user) {
                    if (Hash::check($password, $user->password)) {
                        $value = [
                            'user' => $user,
                            'active_plan' => $user->expire_test_plan > Carbon::now() or $user->pay ? true : false,
                            'active_number' => $user->active_number != null ? true : false,
                            'device_id' => $user->device_id != null ? true : false,
                            'backup_number' => $user->backup_number != null ? true : false,
                            'invite_count' => count(InvitedUser::where('invite_id', $user->id)->get()),
                            'wallet' => UserWallet::where('user_id', $user)->sum('amount') . ' تومان'
                        ];
                        $status = true;
                    } else {
                        $message = 'اطلاعات ورود اشتباه است.';
                        $value = json_decode('{}');
                        $status = false;
                    }
                } else {
                    $message = 'اطلاعات ورود اشتباه است.';
                    $value = json_decode('{ }');
                    $status = false;
                }
            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{}');
                $status = false;
            }
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function getPlans(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $value = Action::all();
            $status = true;
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function activePlans(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $value = Plans::where('deleted', '0')->get();
            $status = true;
        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function buyByAPI(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            $plan = Plans::where('deleted', '0')->where('id', $request->id)->get();
            $user = User::where('username', $request->username)->first();
            if (!$user) {
                return view('Payments.error_redirect_to_bank')->with([
                    'pageName' => 'کاربر مورد نظر پیدا نشد!',
                ]);
            }
            if (!$plan) {
                return view('Payments.error_redirect_to_bank')->with([
                    'pageName' => 'پلن مورد نظر اشتباه است',
                ]);
            }
            GlobalClass::setExpirePlan(Pay::where('expired', 0)->get());
            $myActivePlan = Pay::where('user_id', $user->id)->where('expired', 0)->first();
            if ($myActivePlan) {
                return view('Payments.error_redirect_to_bank')->with([
                    'pageName' => 'شما یک پلن فعال دارید و قادر به خرید پلن جدید تا پایان اعتبار پلن خود نیستید.',
                ]);
            }
            $multiBuy = $plan->multi_buy;
            if (!$multiBuy) {
                $myPays = Pay::where('user_id', $user->id)->where('plan_id', $plan->id)->first();
                if ($myPays) {
                    return view('Payments.error_redirect_to_bank')->with([
                        'pageName' => 'این پلن قابلیت فقط یک بار خرید را دارد!',
                    ]);
                }
            }

            if ($plan->type != 'free') {
//            Payments::pay($plan->amount, $plan->id, $user->id);
                try {
                    $gateway = \Gateway::mellat();
                    $gateway->setCallback(url('http://www.moboyab.com/callback/from/bank'));
                    $gateway->price($plan->amount * 10)->ready();
                    $refId = $gateway->refId();
                    $transID = $gateway->transactionId();
                    $pay = new Pay();
                    $pay->user_id = $user->id;
                    $plan = Plans::find($plan->id);
                    $pay->ref_id = $refId;
                    $pay->expired = 1;
                    $pay->plan_id = $plan->id;
                    $pay->amount = $plan->amount;
                    $pay->start_date = Carbon::now();
                    if ($plan->type == 'monthly')
                        $pay->end_date = Carbon::now()->addMonths($plan->time);
                    else
                        $pay->end_date = null;
                    $pay->save();
                    return $gateway->redirect();

                } catch (Exception $e) {
                    return view('Payments.error_redirect_to_bank')->with([
                        'pageName' => $e->getMessage(),
                    ]);
                }
            } elseif ($plan->type == 'free') {
                $request->offsetSet('id', $id);
                $request->offsetSet('user_id', $user->id);
                if ($this->Bought($request)) {
                    return view('Payments.error_redirect_to_bank')->with([
                        'pageName' => 'متاسفانه خطایی رخ داد!',
                    ]);
                } else
                    return view('Payments.error_redirect_to_bank')->with([
                        'pageName' => 'انتقال به درگاه بانک',
                    ]);
            }
        } catch
        (\Exception  $message) {
            view('Payments.error_redirect_to_bank')->with([
                'pageName' => 'متاسفانه خطایی رخ داد!',
            ]);
        }
    }

    public function sendNotif(Request $request)
    {
        $message = '';
        $value = '{}';
        $status = false;
        try {
            if (FcmClass::send_fcm_message($request->get('title'), $request->get('message'), explode(",", $request->get('users')), $request->get('data'))) {
                $message = 'پیام ارسال شد.';
                $value = json_decode('{ }');
                $status = true;
            } else {
                $message = 'پیام ارسال نشد!';
                $value = json_decode('{ }');
                $status = false;

            }

        } catch
        (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{ }');
            $status = false;
        }
        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function addBackup(Request $request)
    {
        $user = auth('api')->user();

        try {
            $message = $request->message;
            $subject = $request->subject;
            $tag = $request->tag;
            if ($message != null && ($subject != null or $tag != null)) {
                $bm = new BackupMessages();
                if (!$tag) {
                    do {
                        $tag = str_random(5);
                        $oTag = BackupMessages::where('tag', $tag)->first();
                    } while (!empty($oTag));
                } else {
                    $bm->reply = 1;
                }
                $bm->user_id = $user->id;
                $bm->name = $user->full_name;
                $bm->email = $user->email;
                $bm->message = $request->get('message');
                $bm->subject = $request['subject'];
                $bm->from_id = $user->id;
                $bm->ip = 'api';
                $bm->tag = $tag;
                $bm->save();
                $status = true;
                $message = 'پیام شما با موفقیت ثبت شد.لطفا تا دریافت جواب شکیبا باشید.';
                $value = $bm;

            } else {
                $message = 'همه ی پارامتر ها را وارد کنید.';
                $value = json_decode('{}');
                $status = false;
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{}');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function getBackup(Request $request)
    {
        $user = auth('api')->user();

        try {
            $id = $request['message_id'];
            if ($id) {
                $tag = $request['tag'];
                $bMessage = BackupMessages::find((int)$id);
                if ($tag == $bMessage->tag and $user->id == $bMessage->from_id) {//, 'desc'
//            $Message = \DB::table('message')->where('backup_id', '=', (int)$id)->orderBy('created_at', 'desc')->get();
                    $Message = BackupMessages::where('tag', $tag)->orderBy('created_at', 'desc')->get();

                    BackupMessages::where('tag', $tag)->where('status', 'new')->update(['status' => 'visit']);

                    $status = true;
                    $message = '';
                    $value = [
                        'message' => $bMessage,
                        'messages' => $Message
                    ];
//
                } else {
                    $message = 'اطلاعات ورود اشتباه اشت.';
                    $value = json_decode('{}');
                    $status = false;
                }
            } else {
                $status = true;
                $message = '';
                $value = BackupMessages::where('user_id', $user->id)->where('reply', '0')->orderBy('created_at', 'desc')->get();
            }
        } catch (\Exception  $message) {
            $message = 'error : msg->' . $message->getMessage() . ' line->' . $message->getLine() . ' code->' . $message->getCode();
            $value = json_decode('{}');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function getRevenues(Request $request)
    {
        $user = auth('api')->user();

        $amount = $request->get('amount');
        $IBAN = $request->get('IBAN');
        if (!$IBAN) {
            $IBAN = $user->IBAN;
        }
        if ($IBAN) {
            $credit = UserWallet::where('user_id', $user->id)->sum('amount');
            if ($amount and $amount < 50000) {
                $message = 'حداقل مبلغ قابل برداشت 50هزار تومان هست.';
                $value = json_decode('{}');
                $status = false;
            } else {
                $uw = new UserWallet();
                $uw->user_id = $user->id;
                $uw->type = 'harvest';
                if ($amount) {
                    if ($amount > $credit) {
                        $message = 'مبلغ درخواستی بیشتر از حساب شماست.';
                        $status = false;
                    } else {
                        $uw->save();
                        $status = true;
                        $uw->amount = $amount * -1;
                        $message = 'درخواست شما با موفقیت ثبت شد. حداکثر تا سه روز کاری دیگر مبلغ ارسال خواهد شد.';
                    }
                } else {
                    if ($credit < 50000) {
                        $message = 'حداقل مبلغ قابل برداشت 50هزار تومان هست.';
                        $status = false;
                    } else {
                        $uw->save();
                        $status = true;
                        $uw->amount = $credit * -1;
                        $message = 'درخواست شما با موفقیت ثبت شد. حداکثر تا سه روز کاری دیگر مبلغ ارسال خواهد شد.';
                    }

                }
                $value = json_decode('{}');

            }

        } else {
            $message = 'لطفا شماره شبا را وارد کنید';
            $value = json_decode('{}');
            $status = false;
        }

        return [
            'status' => $status,
            'message' => $message,
            'value' => $value
        ];
    }

    public function revenues(Request $request)
    {
        $user = auth('api')->user();
        $count = $request['count'];

        $payRequests = UserWallet::where('user_id', $user->id)
            ->where('type', 'harvest')->paginate($count);

        return [
            'status' => true,
            'message' => '',
            'value' => $payRequests
        ];
    }

    public function getNews(Request $request)
    {
        return [
            'status' => true,
            'message' => '',
            'value' => News::all()
        ];
    }
}
