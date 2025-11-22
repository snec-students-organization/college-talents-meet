<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FestParticipantsSeeder extends Seeder
{
    public function run()
    {
        $participants = [

            // ==========================
            //        THURAS TEAM
            // ==========================
            ['name' => 'IBRAHIM',      'team' => 'Thuras', 'chest_no' => 101, 'section' => 'senior'],
            ['name' => 'ALTHAF',       'team' => 'Thuras', 'chest_no' => 102, 'section' => 'senior'],
            ['name' => 'THWAYYIB',     'team' => 'Thuras', 'chest_no' => 215, 'section' => 'senior'],
            ['name' => 'SWALIH',       'team' => 'Thuras', 'chest_no' => 116, 'section' => 'senior'],
            ['name' => 'ASHIK',        'team' => 'Thuras', 'chest_no' => 217, 'section' => 'senior'],
            ['name' => 'ABDUL JAWAD',  'team' => 'Thuras', 'chest_no' => 111, 'section' => 'senior'],
            ['name' => 'SAHAD',        'team' => 'Thuras', 'chest_no' => 210, 'section' => 'senior'],
            ['name' => 'ASJAD',        'team' => 'Thuras', 'chest_no' => 109, 'section' => 'senior'],
            ['name' => 'ADHIL',        'team' => 'Thuras', 'chest_no' => 108, 'section' => 'senior'],
            ['name' => 'ABDULLA',      'team' => 'Thuras', 'chest_no' => 208, 'section' => 'senior'],

            ['name' => 'FAYIZ S2',     'team' => 'Thuras', 'chest_no' => 203, 'section' => 'junior'],
            ['name' => 'HAFIZ YASEEN', 'team' => 'Thuras', 'chest_no' => 205, 'section' => 'junior'],
            ['name' => 'YASEEN EA',    'team' => 'Thuras', 'chest_no' => 106, 'section' => 'junior'],
            ['name' => 'BILAL S',      'team' => 'Thuras', 'chest_no' => 113, 'section' => 'junior'],
            ['name' => 'MURSHID',      'team' => 'Thuras', 'chest_no' => 213, 'section' => 'junior'],
            ['name' => 'BILAL MR',     'team' => 'Thuras', 'chest_no' => 214, 'section' => 'junior'],
            ['name' => 'SAIDALI',      'team' => 'Thuras', 'chest_no' => 105, 'section' => 'junior'],

            // ==========================
            //        AQEEDA TEAM
            // ==========================
            ['name' => 'FAYIS D3',     'team' => 'Aqeeda', 'chest_no' => 201, 'section' => 'senior'],
            ['name' => 'MUSLIH KU',    'team' => 'Aqeeda', 'chest_no' => 202, 'section' => 'senior'],
            ['name' => 'RAMEES D3',    'team' => 'Aqeeda', 'chest_no' => 216, 'section' => 'senior'],
            ['name' => 'SHAMNAD D2',   'team' => 'Aqeeda', 'chest_no' => 117, 'section' => 'senior'],
            ['name' => 'BILAL KR',     'team' => 'Aqeeda', 'chest_no' => 204, 'section' => 'senior'],
            ['name' => 'MUZAMMIL',     'team' => 'Aqeeda', 'chest_no' => 112, 'section' => 'senior'],
            ['name' => 'IRFAN',        'team' => 'Aqeeda', 'chest_no' => 211, 'section' => 'senior'],
            ['name' => 'MUTHAQI',      'team' => 'Aqeeda', 'chest_no' => 110, 'section' => 'senior'],
            ['name' => 'ALI JAVAD',    'team' => 'Aqeeda', 'chest_no' => 209, 'section' => 'senior'],
            ['name' => 'FAROOQ',       'team' => 'Aqeeda', 'chest_no' => 103, 'section' => 'senior'],

            ['name' => 'FARIS',        'team' => 'Aqeeda', 'chest_no' => 104, 'section' => 'junior'],
            ['name' => 'SHAMNAD S2',   'team' => 'Aqeeda', 'chest_no' => 206, 'section' => 'junior'],
            ['name' => 'THAMEEM',      'team' => 'Aqeeda', 'chest_no' => 107, 'section' => 'junior'],
            ['name' => 'SHAKIR',       'team' => 'Aqeeda', 'chest_no' => 212, 'section' => 'junior'],
            ['name' => 'UNAIS',        'team' => 'Aqeeda', 'chest_no' => 114, 'section' => 'junior'],
            ['name' => 'AFRIN',        'team' => 'Aqeeda', 'chest_no' => 115, 'section' => 'junior'],
            ['name' => 'RAMEES S1',    'team' => 'Aqeeda', 'chest_no' => 207, 'section' => 'junior'],
        ];

        foreach ($participants as $p) {
            $exists = DB::table('fixed_participants')
                        ->where('chest_no', $p['chest_no'])
                        ->exists();

            if (! $exists) {
                DB::table('fixed_participants')->insert($p);
            }
        }
    }
}
