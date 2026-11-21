<?php

namespace Database\Seeders;

use App\Models\OperatingSystem;
use App\Models\Processor;
use App\Models\User;
use App\Models\Notebook;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->rows(database_path('seeders/data/processzor.txt')) as $r) {
            Processor::updateOrCreate(['id' => (int) $r[0]], ['manufacturer' => $r[1], 'model' => $r[2]]);
        }
        foreach ($this->rows(database_path('seeders/data/oprendszer.txt')) as $r) {
            OperatingSystem::updateOrCreate(['id' => (int) $r[0]], ['name' => $r[1]]);
        }
        foreach ($this->rows(database_path('seeders/data/gep.txt')) as $r) {
            Notebook::updateOrCreate(['manufacturer' => $r[0], 'model' => $r[1]], ['screen_size' => (float) str_replace(',', '.', $r[2]), 'memory_mb' => (int) $r[3], 'disk_gb' => (int) $r[4], 'graphics' => $r[5], 'price' => (int) $r[6], 'processor_id' => (int) $r[7], 'operating_system_id' => (int) $r[8]]);
        }
        User::firstOrCreate(['email' => 'admin@renew.local'], ['name' => 'Admin', 'password' => 'admin12345', 'role' => 1]);
    }

    private function rows(string $file): array
    {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_map(fn ($line) => explode("\t", $line), array_slice($lines, 1));
    }
}

