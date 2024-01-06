<x-layouts.app
  type="article"
  subtitle=" - Lorem ipsum"
  author="Lorem"
  cover_path="storage/static/seo-cover.png"
  description="Article about lorem ipsum"
  keywords="lorem, ipsum, dolor, amet"
>
  @push('pageStyles')
    @vite('resources/css/app-tailwind.css')
  @endpush
  <div class="tw-mt-[56px] tw-max-w-lg tw-mx-auto tw-prose tw-prose-md">
    <h1>Lorem ipsum</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis, quaerat.</p>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Obcaecati facere autem reiciendis molestias a molestiae!</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias excepturi unde labore officia pariatur quod a ut earum quibusdam soluta.</p>
  </div>
</x-layouts.app>
