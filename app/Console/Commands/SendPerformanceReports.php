<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\User;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\PerformanceReportMail;

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
            if (empty($user->email)) {
                $this->warn("У пользователя ID {$user->id} не указан email.");
                continue;
            }

            $performance = $user->grades->pluck('grade', 'subject')->toArray();
            
            Mail::to($user->email)->send(
                new PerformanceReportMail($user, $performance)
            );
        }

        $this->info('Все отчеты отправлены!');
    }
}
