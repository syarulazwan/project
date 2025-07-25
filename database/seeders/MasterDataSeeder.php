<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = [
            'admin.sql',
        ];

        foreach ($files as $file) {
            $path = database_path("sql/{$file}");

            if (File::exists($path)) {
                DB::unprepared(File::get($path));
                $this->command->info("Imported: {$file}");
            } else {
                $this->command->error("File not found: {$file}");
            }
        }
    }
}
