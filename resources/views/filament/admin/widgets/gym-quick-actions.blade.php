<x-filament-widgets::widget>
	<x-filament::section>
		<div class="flex items-center justify-between">
			<h3 class="text-base font-semibold">Quick Actions</h3>
			<x-filament::button wire:click="callMountedAction('approveAllPending')">
				Approve All Pending
			</x-filament::button>
		</div>
	</x-filament::section>
</x-filament-widgets::widget>


