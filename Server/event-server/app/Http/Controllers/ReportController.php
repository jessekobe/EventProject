<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Report;
use App\User;
use JWTAuth;

use Input;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    protected $report;
    protected $pusher;
    protected $user;
    protected $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'report';

    public function __construct(Report $report)
    {
        $this->report = $report;
        $this->pusher = App::make('pusher');
        $this->chatChannel = self::DEFAULT_CHAT_CHANNEL;
        $this->middleware('jwt.auth', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $reports = Report::all();
 
        return $reports;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $report = $request->all();
        $report['owner_id'] = $user->id;
        $trigger_report = array('name' => $report['name'],
                               'message' => $report['message'],
                               'info' => $report['info'],
                               'owner_id' => $report['owner_id']
                               );
        $this->report->create($report);

        $this->pusher->trigger(
        $this->chatChannel, 
        'new-report', 
        $trigger_report);

        return response()->json($trigger_report);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $report = Report::all();
 
        if($report){
            $report->is_done=$request->input('is_done');
            $report->save();
            return $report;
        }else{
            return response('Unauthorized',403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $report = Report::all();
 
        if($report){
             Report::destroy($report->id);
            return  response('Success',200);;
        }else{
            return response('Unauthorized',403);
        }
    }
}
