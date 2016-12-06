<?php

use App\reservation;
use App\room;
use App\room_type;
use Illuminate\Http\Request;

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
        $date = new DateTime($request->date);
        $type = room_type::where('name', $request->type)->first();
        $reservations = $type->reservations()
                             ->where('in_year',$date->format('Y'))
                             ->where('in_month', $date->format('m'))
                             ->orWhere(function ($query) use ($date, $type){
                                    $query->where('room_type_id', $type->id)
                                          ->where('out_year', $date->format('Y'))
                                          ->where('out_month', $date->format('m'));
                                        })
                             ->get();
        $rooms = room::where('avail', 1)->where('type_id',$type->id)->count();
        $response = array("now" => $now, "nos" => $total, 'reservations' => $reservations, 'month' => $date->format('m'), 'rooms' => $rooms);
        return response()->json($response);
    
    });

});
