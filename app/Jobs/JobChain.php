<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;


class JobChain implements ShouldQueue
{
    private $name;
    private $uuid;
    private $providerId;
    private $url;
    private $submitTime;
    private $user;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct($name)
    {
        $this->name =  $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            var_dump($this->name);
            sleep(5);
            \Log::info('Name of the person logging : ' . json_encode($this->name));
        } catch (\Exception $e) {
            \Log::info('Job Chain executed with error : ' . json_encode($e));
        }
    }
}

