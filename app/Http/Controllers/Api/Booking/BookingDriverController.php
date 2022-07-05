<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Booking;
use App\Models\Vechile;
class BookingDriverController extends Controller
{
    public function show_books(Request $request)
    {
        $data =  Booking::all();
        $request->validate([
            'vechile_id'   => 'required|string',
        ]);
        $vechile = Vechile::find($request->vechile_id);
        if($vechile !== null){
            return data;
        }
    }
}
