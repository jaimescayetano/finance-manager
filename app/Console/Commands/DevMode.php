<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DevMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dev-mode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $exitCode = Artisan::call('migrate:fresh --seed');

            if ($exitCode === 0) {
                echo ('* Migrations executed successfully' . PHP_EOL);
            } else {
                echo ('* Error executing migrations. Exit code: ' . $exitCode . PHP_EOL);
                return;
            }

            $exitCode = Artisan::call('optimize');

            if ($exitCode === 0) {
                echo ('* Optimization executed successfully' . PHP_EOL);
            } else {
                echo ('* Error executing optimize. Exit code: ' . $exitCode . PHP_EOL);
                return;
            }
        } catch (\Exception $e) {
            echo ('* An error occurred: ' . $e->getMessage() . PHP_EOL);
            return;
        }
    }
}
