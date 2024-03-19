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


    function getReservations()
    {
        // Get all reservations, sort them by date, dont check user id 
        $reservations = Reservation::orderBy('date', 'asc')->get();

        // make data more human readable
        foreach ($reservations as $reservation) {

            // set date to human readable format (e.g. 2024-03-12 to 12.03.2024)
            $reservation->date = date('d.m.Y', strtotime($reservation->date));

            // remove the date from the time
            $reservation->starts_at = date('H:i', strtotime($reservation->starts_at));
            $reservation->ends_at = date('H:i', strtotime($reservation->ends_at));
        }



        // return the reservations
        return view('home', ['reservations' => $reservations]);

    }

}
