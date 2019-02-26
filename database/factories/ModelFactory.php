<?php

$factory->define(App\Action::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'comment' => $faker->text,
        'code' => rand(0,999),
        'status' => $faker->randomElement(['available' ,'expired', 'soon']),
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\ActiveCode::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'active_code_status' => $faker->randomElement(['used' ,'not_used', 'waiting']),
        'deleted_at' => $faker->dateTimeBetween(),
        'active_code' => str_random(6),
    ];
});

$factory->define(App\App::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'version_code' => $faker->boolean,
        'version_name' => $faker->word,
        'download_link' => $faker->word,
        'cost' => $faker->randomFloat(),
        'off' => $faker->randomFloat(),
        'deleted_at' => $faker->dateTimeBetween(),
        'downloaded_count' => $faker->randomNumber(),
    ];
});

$factory->define(App\BackupNumber::class, function (Faker\Generator $faker) {
    return [
        'backup_number' => $faker->word,
        'user_id' => factory(App\User::class)->create()->id,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Call::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'call_type' => $faker->boolean,
        'number' => $faker->word,
        'date' => $faker->word,
        'device_id' => factory(App\Device::class)->create()->id,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\ChangeSim::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'new_number' => $faker->word,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Blog::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->word,
        'body' => $faker->word,
        'images_one' => $faker->word,
        'images_two' => $faker->word,
        'images_three' => $faker->word,
        'news_status' => $faker->randomElement(['waiting' ,'published', 'archived']),
        'user_id' => factory(App\User::class)->create()->id,

    ];
});

$factory->define(App\Device::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'device_id' => $faker->word,
        'status' => $faker->boolean,
        'reg_id' => $faker->word,
    ];
});

$factory->define(App\Email::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'email' => $faker->safeEmail,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'action_id' => factory(App\Action::class)->create()->id,
        'status' => $faker->randomElement(['not_send' ,'send', 'deliver','finish','failed']),
        'deleted_at' => $faker->dateTimeBetween(),
        'location_flag' => $faker->boolean,
    ];
});

$factory->define(App\Iban::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'iban' => $faker->word,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Invite::class, function (Faker\Generator $faker) {
    return [
        'caller_id' => factory(App\User::class)->create()->id,
        'invited_id' => factory(App\User::class)->create()->id,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Location::class, function (Faker\Generator $faker) {
    return [
        'event_id' => factory(App\Event::class)->create()->id,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});



$factory->define(App\RoberFace::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'img_src' => $faker->word,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->safeEmail,
        'email_verified_at' => $faker->dateTimeBetween(),
        'role' => $faker->randomElement(['admin' ,'user']),
        'password' => bcrypt($faker->password),
        'code' => str_random(4),
        'star' => $faker->randomFloat(),
        'credit' => $faker->randomNumber(),
        'avatar' => $faker->word,
        'active_number' => $faker->word,
        'buy_status' => $faker->boolean,
        'account_status' => $faker->randomElement(['active' ,'deactive', 'block']),
        'expire_plan' => $faker->dateTimeBetween(),
        'api_token' => $faker->word,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\UserPay::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'ref_id' => $faker->word,
        'trans_id' => $faker->word,
        'app_id' => factory(App\App::class)->create()->id,
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\UserWallet::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'caller_id' => factory(App\User::class)->create()->id,
        'type' => $faker->randomElement(['deposit' ,'harvest']),
        'amount' => $faker->randomFloat(),
        'status' => $faker->randomElement(['waiting' ,'accept', 'reject']),
        'deleted_at' => $faker->dateTimeBetween(),
    ];
});


$factory->define(App\Ticket::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'title'=>$faker->title(),
        'priority' => $faker->word,
        'message' => $faker->text,
    ];
});

