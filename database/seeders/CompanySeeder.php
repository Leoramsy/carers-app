<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
Use App\Models\System\Company;
use DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->command->info('Creating company...');        
        
            $company = new Company();
            $company->country_id = 226;
            $company->name = 'Rusco Care';
            $company->postal_address_1 = '24 Bifrons Rd';
            $company->postal_address_2 = 'Patrixbourne, Canterbury';
            $company->postal_address_3 = 'United Kingdom';
            $company->postal_post_code = 'CT4 5DE';
            $company->contact_person = 'Maria'; 
            $company->telephone_number = '0624740015';
            $company->cell_number = '0624740015';
            $company->fax_number = '0624740015';
            $company->email = 'talentmbedzi@gmail.com';
            $company->active = TRUE;
            $company->save();       
        
    }
}
