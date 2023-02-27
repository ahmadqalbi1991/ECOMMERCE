<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($site_setting->site_name) ? $site_setting->site_name . " Dashboard" : "Dashboard" }} </title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    @if(!Auth::user())
        <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    @endif
    <link rel="shortcut icon"
          href="{{ isset($site_setting->favicon) ? asset('/' . $site_setting->favicon) : asset('assets/images/logo/favicon.png') }}"
          type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/widgets/select2.min.css') }}">
    @stack('styles')
</head>
