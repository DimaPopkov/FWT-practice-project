<?php

namespace App\Jobs;

use App\Mail\PerformanceReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPerformanceEmail implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $user, protected array $performance)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->user->email)->send(
                new PerformanceReportMail($this->user, $this->performance)
            );
        } catch (\Exception $exception) {
            Log::channel('email')->critical("Ошибка отправки email пользователю ID: {$this->user->id}", [
                'error' => $exception->getMessage()
            ]);
            
            throw $exception;
        }
    }
}
