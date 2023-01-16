<?php

namespace App\Jobs;

use App\Repositories\Integrations\MessageSender;
use App\Repositories\Utils\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($book)
    {
        $this->book = $book;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        MessageSender::dispatchNotify($this->book);
    }
}
