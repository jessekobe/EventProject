<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;


use Input;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class MessagesController extends Controller
{
    protected $message;
    protected $pusher;
    protected $user;
    protected $chatChannel;

    //const DEFAULT_CHAT_CHANNEL = 'messages';
    const DEFAULT_CHAT_CHANNEL = 'message';

    public function __construct(Message $message)
    {
    	$this->message = $message;
    	$this->pusher = App::make('pusher');
        //$this->user = JWTAuth::parseToken()->authenticate();
        $this->chatChannel = self::DEFAULT_CHAT_CHANNEL;
        $this->middleware('jwt.auth', ['except' => ['index']]);
    }

    public function index()
    {
    //$messages = $this->message->orderBy('id', 'desc')->take(5)->get();

    ///return response()->json(array('message' => $request->message));
        return view('chat', ['chatChannel' => $this->chatChannel]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
    $message = $this->user->messages()->create(array('message' => $request->message));

        $this->pusher->trigger(
    	$this->chatChannel, 
    	'new-message', 
    	array('message' => $request->message));

    return response()->json(array('message' => $request->message));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    $message = $this->message->findOrFail($id);

    return response()->json(array('name' => $request->name, 
    	'body' => $request->body));
    }

    public function fetchMessages(Request $request)
    {
    return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $message = array('user_id' => $user->id, 'message' => $request->message);

        $this->pusher->trigger(
    	$this->chatChannel, 
    	'new-message', 
    	array('message' => $request->message));
        
        $this->message->create($message);
        return response()->json(array('message' => $request->message));
    }

    public function postAuth(Request $request)
	{
        if (JWTAuth::parseToken()->authenticate()) {
            $socketId = $request->input('socket_id');
            $channel = $request->input('channel_name');
            $auth = $this->pusher->socket_auth($channel, $socketId);

            return response()->json($auth);
        }

       return response()->json(array('401' => 'Unauthorized'));
	}

}
