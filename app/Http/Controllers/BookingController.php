<?php

namespace App\Http\Controllers;

use App\Events\BookingCreatedEvent;
use App\Events\BookingDeletedEvent;
use App\Events\BookingUpdatedEvent;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::query()
            ->with(['user'])
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $booking = $request->user()->bookings()->create([
            'start' => fromUserDateTime($request->validated('start'), $request->user()),
            'end' => fromUserDateTime($request->validated('end'), $request->user()),
        ]);

        event(new BookingCreatedEvent($booking));

        return redirect()->route('booking.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $booking->update([
            'start' => fromUserDateTime($request->validated('start'), $request->user()),
            'end' => fromUserDateTime($request->validated('end'), $request->user()),
        ]);

        event(new BookingUpdatedEvent($booking));

        return redirect()->route('booking.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === $request->user()->id, 404);

        $booking->delete();

        event(new BookingDeletedEvent($booking));

        return redirect()->route('booking.index');
    }
}
