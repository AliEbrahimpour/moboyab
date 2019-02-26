<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $Action = factory(App\Action::class, 10)->create();
        $User = factory(App\ActiveCode::class, 10)->create();
        $User = factory(App\App::class, 10)->create();
        $User = factory(App\BackupNumber::class, 10)->create();
        $User = factory(App\Blog::class, 10)->create();
        $User = factory(App\Call::class, 10)->create();
        $User = factory(App\ChangeSim::class, 10)->create();
        $User = factory(App\Device::class, 10)->create();
        $User = factory(App\Email::class, 10)->create();
        $User = factory(App\Event::class, 10)->create();
        $User = factory(App\Iban::class, 10)->create();
        $User = factory(App\Invite::class, 10)->create();
        $User = factory(App\Location::class, 10)->create();
        $User = factory(App\RoberFace::class, 10)->create();
        $User = factory(App\User::class, 10)->create();
        $User = factory(App\UserPay::class, 10)->create();
        $User = factory(App\UserWallet::class, 10)->create();

    }
}
