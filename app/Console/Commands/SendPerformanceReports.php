<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\User;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Mail\PerformanceReportMail;

use App\Jobs\SendPerformanceEmail;

class SendPerformanceReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Рассылка успеваемости всем пользователям';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $performance = $user->grades->pluck('score', 'subject')->toArray();

            if (count($performance) > 0) {
                SendPerformanceEmail::dispatch($user, $performance)
                    ->onQueue('emails');
            }
        }
        $this->info('Задачи на отправку добавлены в очередь!');
    }
}
