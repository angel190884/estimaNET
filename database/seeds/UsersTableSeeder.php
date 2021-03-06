<?php
/**
 * Seeder Users
 *
 * Seeder Users Add.
 *
 * PHP version 7.1
 *
 * @category   Components
 * @package    WordPress
 * @subpackage Theme_Name_Here
 * @author     Your Name <yourname@example.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://yoursite.com
 * @since      1.0.0
 */

use App\Contract;
use App\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

/**
 * UsersTableSeeder Class Doc Comment
 *
 * @category Class
 * @package  MyClass
 * @author   Your Name <yourname@example.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * +------------------------------------------------------------+
         * | Role: admin                                                |
         * +------------------------------------------------------------+
         */

        \Bouncer::allow('admin')->to(
            [
                //Contracts
                'viewContract',
                'listContracts',
                'newContract',

                //Companies
                'viewCompany',
                'listCompanies',
                'newCompany',

                //Estimates
                'viewEstimate',
                'listEstimates',
                'newEstimate',
                'monitoringEstimates',

                //Concept
                'viewConcept',
                'listConcepts',
                'newConcept',

                //Locations
                'viewLocation',
                'listLocations',
                'newLocation',

                //Deductions
                'listDeductions',

            ]
        );

        $user = factory(User::class)->create(
            [
                'name' => 'angel daniel peregrino juarez',
                'email' => 'angel190884@gmail.com'
            ]
        );
        $user->assign('admin');

        /**
         * +------------------------------------------------------------+
         * | Role: visor                                                |
         * +------------------------------------------------------------+
         */
        \Bouncer::allow('editor')->to(
            [
                //Contracts
                'viewContract',
                'listContracts',
                'newContract',

                //Companies
                'viewCompany',
                'listCompanies',
                'newCompany',

                //Estimates
                'viewEstimate',
                'listEstimates',
                'newEstimate',
                'monitoringEstimates',

                //Concept
                'viewConcept',
                'listConcepts',
                'newConcept',

                //Locations
                'viewLocation',
                'listLocations',
                'newLocation',

                //Deductions
                'listDeductions',

            ]
        );

        $user = factory(User::class)->create(
            [
                'name' => 'angel daniel peregrino juarez',
                'email' => 'angel_190884@hotmail.com'
            ]
        );
        $user->assign('editor');
        /**
         * +------------------------------------------------------------+
         * | Role: visor                                                |
         * +------------------------------------------------------------+
         */
        \Bouncer::allow('visor')->to(
            [
                'monitoringEstimates',
            ]
        );

        $user = factory(User::class)->create(
            [
                'name' => 'visor',
                'email' => 'visor@visor.com'
            ]
        );
        $user->assign('visor');
        
    }
}
