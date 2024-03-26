<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;


include_once(app_path('Helpers/RedirectFunction.php'));

class ReservationController extends Controller
{

    protected function sqlQueryJoinTables()
    {

        /* SQL

        SELECT reservations.date, users.name, reservations.subject, reservations.starts_at, reservations.ends_at
        FROM railway.reservations
        INNER JOIN railway.users ON users.id = reservations.user_id
        ORDER BY reservations.date ASC;

        */


        // join tables and select the data from the reservations table and the users table. Order the data by date in ascending order
        $result = Reservation::select('reservations.id', 'reservations.date', 'reservations.user_id', 'users.name', 'reservations.subject', 'reservations.starts_at', 'reservations.ends_at')
            ->join('users', 'users.id', '=', 'reservations.user_id')
            ->orderBy('reservations.date', 'asc')
            ->get();

        return $result;
    }

    function newReservation(Request $req)
    {


        // validate the incoming request data
        $validator = Validator::make($req->all(), [
            'subject' => ['required', 'max:255'],
            'time_from' => ['required', 'date'],
            'time_to' => ['required', 'date'],
        ]);


        if ($validator->fails()) {
            // If validation fails, redirect back to the form with the errors
            return ValidatorRedirect(url()->previous(), $validator, '#form');
        } else {
            // Push the validated data to the database

            // get all the incoming request data and create a new reservation instance
            $reservation = new Reservation();

            // check if the $req->time_from is in the past
            if (strtotime($req->time_from) < time()) {

                // throw new error message if the time_from is in the past
                $validator->errors()->add('time_from', 'You cannot create a reservation in the past');

                return ValidatorRedirect(url()->previous(), $validator, '#form');
            }

            // check if the difference between the time_from and time_to is bigger than 1 day
            if (strtotime($req->time_to) - strtotime($req->time_from) > 86400) {

                // throw new error message if the difference between the time_from and time_to is bigger than 1 day
                $validator->errors()->add('time_to', 'You cannot create a reservation that is longer than 24 hours');

                return ValidatorRedirect(url()->previous(), $validator, '#form');
            }


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

            // get new reservations
            $newReservationList = $this->getReservationsHelper();

            // return a success message
            return view('home', ['reservations' => $newReservationList]);
        }
    }

    function newReservationGetMethod()
    {
        return redirect('/home');
    }

    function getReservationsHelper()
    {
        $reservations = $this->sqlQueryJoinTables();

        // make data more human readable
        foreach ($reservations as $reservation) {

            // set date to human readable format (e.g. 2024-03-12 to 12.03.2024)
            $reservation->date = date('d.m.Y', strtotime($reservation->date));

            // remove the date from the time
            $reservation->starts_at = date('H:i', strtotime($reservation->starts_at));
            $reservation->ends_at = date('H:i', strtotime($reservation->ends_at));
        }

        return $reservations;
    }


    function getReservations()
    {

        // get the reservations
        $reservations = $this->getReservationsHelper();

        // return the reservations
        return view('home', ['reservations' => $reservations]);
    }

    function deleteReservation()
    {
        // get the reservation id
        $id = request('id');

        // find the reservation by the id
        $reservation = Reservation::find($id);

        // check if the reservation exists
        if ($reservation) {

            // check if the authenticated user is the owner of the reservation
            if ($reservation->user_id == auth()->user()->id) {

                // delete the reservation
                $reservation->delete();

                // get new reservations
                $newReservationList = $this->getReservationsHelper();

                // return a success message
                return view('home', ['reservations' => $newReservationList]);
            }
        }

        // Create a new MessageBag instance
        $errors = new MessageBag();

        // Add a custom error message
        $errors->add('id', 'Reservation not found');

        // If the reservation does not exist, redirect back to the previous page with the error message
        return ValidatorRedirect(url()->previous(), $errors, '');
    }

    function deleteReservationGetMethod()
    {
        return redirect('/home');
    }

    function AdminPanelReservationView()
    {
        // Retrieve all reservations ordered by date
        $reservations = Reservation::orderBy('date', 'asc')->get();

        // Extract distinct dates
        $distinctDates = $reservations->unique('date')->pluck('date');

        // Create an empty array to store reservations grouped by date
        $reservationsByDate = [];

        // Iterate over each distinct date
        foreach ($distinctDates as $date) {
            // Filter reservations by date
            $reservationsForDate = $reservations->where('date', $date);

            // Iterate over each reservation and format the date and time
            foreach ($reservationsForDate as $reservation) {
                $reservation->starts_at = date('H:i', strtotime($reservation->starts_at));
                $reservation->ends_at = date('H:i', strtotime($reservation->ends_at));

                // Remove the date attribute
                unset($reservation->date);
            }

            // Sort reservations by starts_at
            $reservationsForDate = $reservationsForDate->sortBy('starts_at');

            // Store reservations for the current date as an associative array
            $reservationsByDate[$date] = $reservationsForDate->values()->toArray();
        }

        // return the reservations grouped by date
        return view('admin-panel', ['reservationsByDate' => $reservationsByDate]);
    }
}
