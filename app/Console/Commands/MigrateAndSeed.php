<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class MigrateAndSeed extends Command
{
    protected $signature = 'db:migrate:seed';

    protected $description = 'Run migrations and seeders';

    public function handle()
    {
        $this->call('migrate');
        $this->call('db:seed');
        $this->info('Migrations and seeders completed successfully.');
    }
}
