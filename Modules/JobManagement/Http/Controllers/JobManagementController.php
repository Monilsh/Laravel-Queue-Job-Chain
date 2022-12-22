<?php

namespace Modules\JobManagement\Http\Controllers;

use App\Jobs\JobChain;
use App\Jobs\TestSendEmail;
use App\Jobs\TrailHello;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Bus;
use Throwable;

class JobManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('jobmanagement::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('jobmanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('jobmanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('jobmanagement::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

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
