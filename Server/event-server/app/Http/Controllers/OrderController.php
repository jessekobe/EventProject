<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use JWTAuth;

use Input;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $order;
    protected $pusher;
    protected $user;
    protected $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'order';

    public function __construct(Order $order)
    {
        $this->order = $order;
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
        $orders = Order::all();
 
        return $orders;
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
        $order = $request->all();
        $trigger_order = array('table' => $order['table'],
                               'item_name' => $order['item_name'],
                               'item_number' => $order['item_number'], 
                               'price' => $order['price'],
                               'waiter' => $order['waiter'],
                               'image' => $order['image'],
                               'status' => $order['status'],
                               'info' => $order['info'],
                               'owner_id' => $order['owner_id'],
                               );
        $this->order->create($order);

        $this->pusher->trigger(
        $this->chatChannel, 
        'new-order', 
        $trigger_order);

        return response()->json($trigger_order);
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
        $order = Order::all();
 
        if($order){
            $order->is_done=$request->input('is_done');
            $order->save();
            return $order;
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
        $order = Order::all();
 
        if($order){
             Order::destroy($order->id);
            return  response('Success',200);;
        }else{
            return response('Unauthorized',403);
        }
    }
}
