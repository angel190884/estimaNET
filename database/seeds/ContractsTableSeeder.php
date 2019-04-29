<?php

use App\Contract;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Company;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
        for ($i=0;$i <= 10;$i++) {
            $companies = Company::all(); 
            $contract=factory(Contract::class)->create(
                [
                    'type' => 1,
                    'signature_1' => '<p style="text-align: center;"><strong>ELABOR&Oacute;</strong><br />EMPRESA O PERSONA F&Iacute;SICA.</p><p style="text-align: center;"><br /><br />_____________________________________________<br /><strong>NOPMBRE DEL ADMINISTRADOR</strong><br />(ADMINISTRADOR &Uacute;NICO)</p>',
                    'signature_2' => '<p style="text-align: center;"><strong>APROB&Oacute;</strong><br />RESIDENTE DE OBRA</p><p style="text-align: center;"><br /><br />_____________________________________________<br /><strong>NOMBRE DEL FUNCIONARIO</strong><br />(PUESTO DEL FUNCIONARIO)</p>',
                    'signature_3' => '<p style="text-align: center;"><strong>AUTORIZ&Oacute;</strong><br />RESIDENTE DE OBRA</p><p style="text-align: center;"><br /><br />_____________________________________________<br /><strong>NOMBRE DEL FUNCIONARIO</strong><br />(PUESTO DEL FUNCIONARIO)</p>',
                    'signature_4' => '<p style="text-align: center;"><strong>REVIS&Oacute;</strong><br />EMPRESA O PERSONA F&Iacute;SICA.</p><p style="text-align: center;"><br /><br />_____________________________________________<br /><strong>NOPMBRE DEL ADMINISTRADOR</strong><br />(ADMINISTRADOR &Uacute;NICO)</p>',
                    'signature_5' => '<p style="text-align: center;"><strong>REVIS&Oacute;</strong><br />SUPERVISI&Oacute;N INTERNA</p><p style="text-align: center;"><br /><br />_____________________________________________<br /><strong>NOMBRE DEL FUNCIONARIO</strong><br />(PUESTO DEL FUNCIONARIO)</p>',
                    'signature_6' => ' ',
                ]
            );
            $contract->companies()->attach($companies->random());

        }

        //Bouncer::allow('admin')->everything();
        //Bouncer::allow('visor')->to('viewContract', Contract::class);
    }
}
