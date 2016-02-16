<?php

use Illuminate\Database\Seeder;

class SocialFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('psychosocial_support_lookup')->insert(
            array(
                array('description'   => 'Ενδυνάμωση-Αυτενέργεια ατόμου'),
                array('description'   => 'Ενίσχυση αυτοεκτίμησης και αυτοπεποίθησης'),
                array('description'   => 'Συνεργασία με οικογένεια για την αντιμετώπιση oικογενειακών ή άλλων προβλημάτων'),
                array('description'   => 'Εκπαίδευση-Κατάρτιση'),
                array('description'   => 'Νομικά ζητήματα'),
                array('description'   => 'Εκμάθηση τεχνικών αναζήτησης εργασίας'),
            )
        );
    }
}
