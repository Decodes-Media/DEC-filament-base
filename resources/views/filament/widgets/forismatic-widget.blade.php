<x-filament::widget>
  <x-filament::card>
    <p class="mb-2 text-xl text-neutral-600 dark:text-neutral-300">
      @lang('admin.welcome') {{ $username }}.
    </p>
    <p class="mb-4 text-lg text-neutral-600 dark:text-neutral-300">
      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="inline-block h-8 w-8 pr-2" viewBox="0 0 24 24">
        <path d="M13 14.725c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275zm-13 0c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275z"></path>
      </svg>
      @if (filled($this->quote))
        <i>{{ $this->quote['quoteText'] }} —{{ $this->quote['quoteAuthor'] ?: 'Unknown' }}</i>
      @endif
    </p>
  </x-filament::card>
</x-filament::widget>
