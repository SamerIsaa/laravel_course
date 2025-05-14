<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckEndedSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-ended-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Ended Subscriptions and make it\'s  status to 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $provider = $this->argument('provider');


        User::query();
//            ->whereDate('end_date' , '<=' , now()->toDateString())
//            ->update(['is_active' => 0]);

        $this->info("operation done successfully");

    }
}
