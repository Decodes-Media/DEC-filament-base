<div class="flex items-center flex-row">
  <img src="{{ storage_url(setting('site.logo_light_path')) }}" alt="Logo Light" class="inline-block dark:hidden" style="height:42px">
  <img src="{{ storage_url(setting('site.logo_dark_path')) }}" alt="Logo Dark" class="hidden dark:inline-block" style="height:42px">
  <div class="mx-2 text-2xl font-bold">&nbsp; {{ setting('app.short_name') }}</div>
</div>
