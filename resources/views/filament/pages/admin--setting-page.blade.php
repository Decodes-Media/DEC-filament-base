<x-filament::page>
  <form wire:submit.prevent="submit" class="space-y-6">
    {{ $this->form }}
    @if (! $this->disableForm)
      <div class="flex flex-wrap items-center gap-4 justify-start">
        <x-filament::button type="submit">
          @lang('admin.save')
        </x-filament::button>
      </div>
    @endif
  </form>
  <x-filament-actions::modals />
</x-filament::page>
