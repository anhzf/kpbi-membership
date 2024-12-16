<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DailyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch daily cron jobs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call(NotifyMembershipExpiry::class);
        return Command::SUCCESS;
    }
}
