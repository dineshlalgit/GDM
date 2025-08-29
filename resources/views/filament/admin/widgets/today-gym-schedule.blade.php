<x-filament-widgets::widget>
	<x-filament::section>
		<h3 class="text-base font-semibold mb-4">Today's Gym Schedule</h3>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
			@foreach($slots as $slot)
				@php
					$booked = $slot->getBookedCount();
					$full = $slot->isFull();
				@endphp
				<div @class([
					'rounded-lg p-4 border',
					'bg-red-50 border-red-200' => $full,
					'bg-green-50 border-green-200' => !$full,
				])>
					<div class="text-center font-semibold">{{ \Illuminate\Support\Carbon::parse($slot->start_time)->format('H:i') }}-{{ \Illuminate\Support\Carbon::parse($slot->end_time)->format('H:i') }}</div>
					<div class="text-center text-sm text-gray-600">{{ $booked }}/{{ $slot->capacity }}</div>
					<div class="mt-2 text-center">
						<x-filament::badge color="{{ $full ? 'danger' : 'success' }}">{{ $full ? 'Full' : 'Available' }}</x-filament::badge>
					</div>
				</div>
			@endforeach
		</div>
	</x-filament::section>
</x-filament-widgets::widget>


