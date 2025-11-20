<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FestParticipantsSeeder extends Seeder
{
    public function run()
{
    $participants = [
        // THURAS TEAM
        ['name' => 'IBRAHIM',     'team' => 'Thuras', 'chest_no' => 101],
        ['name' => 'ALTHAF',     'team' => 'Thuras', 'chest_no' => 102],
        ['name' => 'THWAYYIB',    'team' => 'Thuras', 'chest_no' => 215],
        ['name' => 'SWALIH',    'team' => 'Thuras', 'chest_no' => 116],
        ['name' => 'ASHIK',    'team' => 'Thuras', 'chest_no' => 217],
        ['name' => 'ABDUL JAWAD',     'team' => 'Thuras', 'chest_no' => 111],
        ['name' => 'SAHAD',    'team' => 'Thuras', 'chest_no' => 210],
        ['name' => 'ASJAD',    'team' => 'Thuras', 'chest_no' => 109],
        ['name' => 'ADHIL',    'team' => 'Thuras', 'chest_no' => 108],
        ['name' => 'ABDULLA',     'team' => 'Thuras', 'chest_no' => 208],

        ['name' => 'FAYIZ S2',     'team' => 'Thuras', 'chest_no' => 203],
        ['name' => 'HAFIZ YASEEN',     'team' => 'Thuras', 'chest_no' => 205],
        ['name' => 'YASEEN EA',    'team' => 'Thuras', 'chest_no' => 106],
        ['name' => 'BILAL S',    'team' => 'Thuras', 'chest_no' => 113],
        ['name' => 'MURSHID',    'team' => 'Thuras', 'chest_no' => 213],
        ['name' => 'BILAL MR',     'team' => 'Thuras', 'chest_no' => 214],
        ['name' => 'SAIDALI',    'team' => 'Thuras', 'chest_no' => 105],
       

        // AQEEDA TEAM
        ['name' => 'FAYIS D3',    'team' => 'Aqeeda', 'chest_no' => 201],
        ['name' => 'MUSLIH KU',    'team' => 'Aqeeda', 'chest_no' => 202],
        ['name' => 'RAMEES D3',    'team' => 'Aqeeda', 'chest_no' => 216],
        ['name' => 'SHAMNAD D2',     'team' => 'Aqeeda', 'chest_no' => 117],
        ['name' => 'BILAL KR',     'team' => 'Aqeeda', 'chest_no' => 204],
        ['name' => 'MUZAMMIL',    'team' => 'Aqeeda', 'chest_no' => 112],
        ['name' => 'IRFAN',    'team' => 'Aqeeda', 'chest_no' => 211],
        ['name' => 'MUTHAQI',     'team' => 'Aqeeda', 'chest_no' => 110],
        ['name' => 'ALI JAVAD', 'team' => 'Aqeeda', 'chest_no' => 209],
        ['name' => 'FAROOQ',     'team' => 'Aqeeda', 'chest_no' => 103],

        ['name' => 'FARIS',     'team' => 'Aqeeda', 'chest_no' => 104],
        ['name' => 'SHAMNAD S2',     'team' => 'Aqeeda', 'chest_no' => 206],
        ['name' => 'THAMEEM',    'team' => 'Aqeeda', 'chest_no' => 107],
        ['name' => 'SHAKIR',    'team' => 'Aqeeda', 'chest_no' => 212],
        ['name' => 'UNAIS',    'team' => 'Aqeeda', 'chest_no' => 114],
        ['name' => 'AFRIN',     'team' => 'Aqeeda', 'chest_no' => 115],
        ['name' => 'RAMEES S1',    'team' => 'Aqeeda', 'chest_no' => 207],
       
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
