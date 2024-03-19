<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    function newReservation(Request $req)
    {


        // validate the incoming request data
        $validator = Validator::make($req->all(), [
            'subject' => ['required', 'max:255'],
            'time_from' => ['required', 'date'],
            'time_to' => ['required', 'date'],
        ]);


        if ($validator->fails()) {
            
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            // Push the validated data to the database

            // get all the incoming request data and create a new reservation instance
            $reservation = new Reservation();

            // set the data
            $reservation->starts_at = $req->time_from;
            $reservation->ends_at = $req->time_to;
            $reservation->subject = $req->subject;

            // Get the date from the time_from
            $reservation->date = date('Y-m-d', strtotime($req->time_from));

            // get the authenticated user id
            $reservation->user_id = auth()->user()->id;

            // save the reservation
            $reservation->save();


            
            return response()->json(['message' => 'Reservation created successfully'], 200);
        }
    }
}
