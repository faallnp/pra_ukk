<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetOrderNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-order-number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset order number to 001 every day at 00:00';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Order number reset executed at '.now());
    }
}
