<?php

use App\guest;
use App\reservation;
use App\room;
use App\room_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::group(['middleware' => 'api'], function() {
	

	Route::post('/postCalandar', function (Request $request) {
		
		$d = strtotime($request->date);
	   	$now = date("F, Y", $d);
        $d = new DateTime($request->date);

        $d->modify( 'first day of this month' );
        $fday = $d->format( 'D' );
        $d->modify( 'last day of this month' );
        $lday = $d->format( 'd' );
        $daysN = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        
        $key = array_search($fday, $daysN);
        $arr = array();
        $total = array();
        
	    $i = 0;
	    $d = 1; 
	    $c = 7;
        for($j = 0; $j < 6; $j++){
            for(; $i < $c; $i++){
                if($i < $key || $d > $lday){ 
                    array_push($arr, '');
                }else{
	        		array_push($arr, $d);
                    $d++;
                }
            }
            $c += 7;
        	array_push($total, $arr);
        	$arr = array();
        }
        $min_date = date("Y-m-1",strtotime($request->date));
        $max_date = date("Y-m-31",strtotime($request->date));
        $type = room_type::where('name', $request->type)->first();
        $reservations = $type->reservations()
                             ->where('start_date','>=',$min_date)
                             ->where('start_date','<=',$max_date)
                             ->orWhere(function ($query) use ($min_date, $max_date, $type){
                                    $query->where('room_type_id', $type->id)
                                          ->where('end_date','>=',$min_date)
                                          ->where('end_date', '<=',$max_date);
                                        })
                             ->get();
        $rooms = room::where('avail', 1)->where('type_id',$type->id)->count();
        $date = date("Y-m",strtotime($request->date));
        $response = array("now" => $now, "nos" => $total, 'reservations' => $reservations, 'date' => $date, 'rooms' => $rooms);
        return response()->json($response);
    
    });


    Route::post('/types', function(Request $request) {
        $types = room_type::has('rooms')->get();
        $freeTypes = array();
        foreach ($types as $type) {
            $room = room::where('type_id', $type->id)
                        ->whereDoesntHave('reservations', function ($query) use ($request) {
                                        $query->where('start_date', '<=' , $request->in)
                                              ->where('end_date','>=', $request->out);
                                })->first();
            if($room != null){
                array_push($freeTypes, $room->room_type);
            }
        }
        $response = array("types" => $freeTypes);
        return response()->json($response);
    });         

    Route::post('/book', function(Request $request) {
        $validator = Validator::make($request->all(), [
            'Check_In' => 'required|date|after:yesterday',
            'Check_Out' => 'required|date|after:Check_In',
            'Room_Type' => 'required',
            'ssn' => 'required',
            'Email' => 'required|email|max:255',
            'Name' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $response = array("errors" => $errors);
            return response()->json($response);
        }
        $type = room_type::where('name',$request->Room_Type)->first();
        $room = room::where('type_id', $type->id)
                    ->whereDoesntHave('reservations', function ($query) use ($request) {
                                    $query->where('start_date', '<=' , $request->Check_In)
                                          ->where('end_date','>=', $request->Check_Out);
                            })->first();

        $guest = guest::where('id',$request->ssn)->first();
        if($guest == null){
            $guest = new guest();
            $guest->id = $request->ssn;
            $guest->name = $request->Name;
            $guest->email = $request->Email;
            $guest->save();
        }

        $reservation = new reservation();
        $reservation->room_id = $room->id;
        $reservation->guest_id = $request->ssn;
        $reservation->start_date = $request->Check_In;
        $reservation->end_date = $request->Check_Out;
        $reservation->room_type_id = $type->id;
        $reservation->floor = $room->floor;
        $reservation->save();

        $eventData = ['event' => 'BookingRoom', 'data' => 'Booking room ' . $reservation->room_id];
        Redis::publish('admin-channel', json_encode($eventData));

        $success = "Room Number ".$room->id."\nReservation Number ".$reservation->id;
        $response = array("success" => $success);
        return response()->json($response);
    });

});
