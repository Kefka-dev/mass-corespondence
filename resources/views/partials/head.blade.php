<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

{{--For laravel quil editor --}}
<!-- Include Bubble Theme -->
<link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

{{--snow theme--}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
