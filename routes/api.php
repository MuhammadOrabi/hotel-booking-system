<?php

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
        $response = array("now" => $now, "nos" => $total);
        return response()->json($response);
	
	});
});
