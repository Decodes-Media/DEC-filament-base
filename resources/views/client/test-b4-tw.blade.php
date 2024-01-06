<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing Bootstrap 4 + Tailwind</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    @vite('resources/css/app-tailwind.css')
</head>
<body>
    <body class="d-flex flex-column h-100">
        <main role="main" class="flex-shrink-0">
          <div class="container">
            <h1 class="mt-5 tw-bg-[#d9b4b4]">Sticky footer</h1>
            <p class="lead">Pin a footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>
          </div>
        </main>
        <article class="mx-auto my-4 tw-prose tw-prose-md">
            <h2>Lorem, ipsum dolor.</h2>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Est, dolorum? Perspiciatis, laborum possimus?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci iste omnis, optio deleniti consequatur quibusdam nesciunt vero quis aspernatur eaque ipsum eveniet non unde?</p>
        </article>
        <footer class="footer mt-auto py-3">
          <div class="container">
            <span class="text-muted">Place sticky footer content here.</span>
          </div>
        </footer>
    </body>
</body>
</html>
