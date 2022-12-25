<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Flare;
use App\Models\questions;
use Database\Factories\questionsFactory;



class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for ($i = 0; $i < 1000; $i++) {
            questions::factory()->create();
        }
        
    }
}
