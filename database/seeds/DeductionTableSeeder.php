<?php

use App\User;
use App\Deduction;
use Illuminate\Database\Seeder;

class DeductionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            factory(Deduction::class)->create(
                [
                'user_id'   => $user->id,
                'code'      => 'S.A.C.O.P.-C.G.',
                'name'      => 'SACOP',
                'percentage'=> 2,
                'type'      => 1,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'S.R.C.O.P.-D.F.',
                'name'      => 'SRCOP',
                'percentage'=> 1.5,
                'type'      => 1,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'SVIC-SVIG IN',
                'name'      => 'SVIC-SVIG IN',
                'percentage'=> 0.5,
                'type'      => 1,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'DSA',
                'name'      => 'DSA',
                'percentage'=> 2,
                'type'      => 1,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'CAP. IMDT',
                'name'      => 'CAP. IMDT',
                'percentage'=> 2,
                'type'      => 1,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'SANCION POR NO ESTIMAR',
                'name'      => 'SANCION POR NO ESTIMAR',
                'percentage'=> 2,
                'type'      => 2,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'SANCION POR MALA CALIDAD EN LOS TRABAJOS',
                'name'      => 'SANCION POR MALA CALIDAD EN LOS TRABAJOS',
                'percentage'=> 2,
                'type'      => 2,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'SANCION POR ENTREGA EXTEMPORANEA',
                'name'      => 'SANCION POR ENTREGA EXTEMPORANEA',
                'percentage'=> 2,
                'type'      => 2,
                'description'=> 'description',
                ]
            );
            factory(Deduction::class)->create(
                [
                'user_id' => $user->id,
                'code'      => 'SANCION POR ENTREGA EXTEMPORANEA EN REPORTES QUINCENALES',
                'name'      => 'SANCION POR ENTREGA EXTEMPORANEA EN REPORTES QUINCENALES',
                'percentage'=> 0.07,
                'type'      => 2,
                'description'=> 'description',
                ]
            );
        }
    }
}
