<?php

namespace App\Jobs;

use Mail;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Data\Constants\JobConstants;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\GuzzleRequests\GuzzleRequest;

class TrailHello implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $adminName;
    private $keyName;
    private $submitTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $timeout = 3600;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;
    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 1 * 60;

    public function __construct($data)
    {
        $this->adminName = $data['name'];
        $this->submitTime = $data['submit_time'];
        $this->keyName = 'helloTrailJob';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $startTime = Carbon::now();
            \Log::info('starting job: ' . $this->keyName);

            \Log::info('Admin Name: ' . $this->adminName);
            sleep(5);

            $endTime = Carbon::now();
            \Log::info('finishing job: ' . $this->keyName . ' at ' . $endTime);

            \Log::info('time to complete ' . $this->keyName . ': ' . $endTime->diffInSeconds($startTime));
        } catch (\Exception $e) {
            Log::info("Job with key $this->keyName has failed, reason ".$e->getMessage());
            $this->release('60s');
        }
    }


    public function failed(Throwable $exception)
    {
        Log::info('job failed for '.$this->keyName.', exception => '.$exception->getMessage());
    }

    public function tags()
    {
        return [$this->adminName, $this->keyName];
    }
}