<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::create(['name' => 'VALİLİK']);
        Partner::create(['name' => 'KAYMAKAMLIK']);
        Partner::create(['name' => 'İL MİLLİ EĞİTİM MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'İLÇE MİLLİ EĞİTİM MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'İL SAĞLIK MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'İLÇE SAĞLIK MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'AİLE VE SOSYAL HİZMETLER İL MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'SOSYAL HİZMET MERKEZİ MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'HUZUREVİ MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'GÖÇ İDARESİ İL MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'GÖÇ İDARESİ İLÇE MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'GENÇLİK ve SPOR İL MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'GENÇLİK ve SPOR İLÇE MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'TARIM ve ORMAN İL MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'TARIM ve ORMAN İLÇE MÜDÜRLÜĞÜ']);
        Partner::create(['name' => 'MERSİN BÜYÜKŞEHİR BELEDİYESİ']);
        Partner::create(['name' => 'AKDENİZ BELEDİYESİ']);
        Partner::create(['name' => 'ANAMUR BELEDİYESİ']);
        Partner::create(['name' => 'AYDINCIK BELEDİYESİ']);
        Partner::create(['name' => 'BOZYAZI BELEDİYESİ']);
        Partner::create(['name' => 'ÇAMLIYAYLA BELEDİYESİ']);
        Partner::create(['name' => 'ERDEMLİ BELEDİYESİ']);
        Partner::create(['name' => 'GÜLNAR BELEDİYESİ']);
        Partner::create(['name' => 'MEZİTLİ BELEDİYESİ']);
        Partner::create(['name' => 'MUT BELEDİYESİ']);
        Partner::create(['name' => 'SİLİFKE BELEDİYESİ']);
        Partner::create(['name' => 'TARSUS BELEDİYESİ']);
        Partner::create(['name' => 'TOROSLAR BELEDİYESİ']);
        Partner::create(['name' => 'YENİŞEHİR BELEDİYESİ']);
    }
}
