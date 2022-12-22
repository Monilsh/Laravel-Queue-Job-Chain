<?php

namespace App\Http\Controllers;

use App\Jobs\JobChain;
use App\Jobs\TrailHello;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Bus;
use Throwable;

class JobManagementController extends Controller
{

    public function test()
    {
        return "Hello";
    }

    public function printHello(Request $request)
    {
        $data = $request->all();
        $data['name'] = 'Romil Kumar';
        $data['submit_time'] = Carbon::now()->timezone('UTC')->format('d/m/Y h:m A') . ' UTC';
        dispatch(new TrailHello($data));
        return ['status' => 'OK', 'message' => 'Added to queue successfully'];
    }

    public function chainJobs(Request $request)
    {
        $names = ['Job Chain', 'Test Job', 'Raj Vora', 'Virat Singh'];

        $jobs = collect($names)->map(function($name){
            return new JobChain($name);
        })->toArray();

        Bus::chain($jobs)->catch(function (Throwable $e) {
            \Log::info('Job chain has failed: ');
        })->dispatch();

        return ['status' => 'OK', 'message' => 'Added to queue successfully'];
    }
}
