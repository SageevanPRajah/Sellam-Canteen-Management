<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div style="margin: 20px;">
                        <a href="{{ route('booking.index') }}"
                           class="rounded-md px-4 py-2 bg-black text-white transition hover:bg-gray-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                            Booking List
                        </a>
                    </div>
                    <div style="margin: 20px;">
                        <a href="{{ route('booking.reaction') }}"
                           class="rounded-md px-4 py-2 bg-black text-white transition hover:bg-gray-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                            Cancel Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
