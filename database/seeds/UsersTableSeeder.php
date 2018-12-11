<?php

use App\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=factory(User::class)->create([
            'name' => 'angel daniel peregrino juarez',
            'email' => 'angel190884@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);

        $user->assign('admin');

        //Bouncer::allow('admin')->everything();

        //Bouncer::allow('visor')->to('viewContract', Contract::class);


    }
}
