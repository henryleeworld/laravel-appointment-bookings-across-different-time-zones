<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('booking.create') }}"
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">{{ __('Create Booking') }}</a>

                    <table class="table-auto w-full mt-8">
                        @if($bookings->count() > 0)
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('ID') }}</th>
                                    <th class="px-4 py-2">{{ __('User') }}</th>
                                    <th class="px-4 py-2">{{ __('Start Date') }}</th>
                                    <th class="px-4 py-2">{{ __('End Date') }}</th>
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td class="border px-4 py-2">{{ $booking->id }}</td>
                                    <td class="border px-4 py-2">{{ $booking->user->name }}</td>
                                    <td class="border px-4 py-2">{{ toUserDateTime($booking->start, auth()->user()) }}</td>
                                    <td class="border px-4 py-2">{{ toUserDateTime($booking->end, auth()->user()) }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="{{ route('booking.edit', $booking->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">{{ __('Edit') }}</a>
                                        @if($booking->user_id === auth()->id())
                                        <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tr><td class="border px-4 py-2 text-center">{{ __('No Data') }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
