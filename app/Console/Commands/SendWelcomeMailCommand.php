<?php

namespace App\Console\Commands;

use App\Mail\SendWelcomeMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailCommand extends Command
{
    use Queueable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-welcome-mail-command {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Welcome Mail Command to User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_id = $this->argument('user');

        $user = User::query()->find($user_id);
        if ($user) {
            Mail::send(new SendWelcomeMail($user));
        }

    }
}
