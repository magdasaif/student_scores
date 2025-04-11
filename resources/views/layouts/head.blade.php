<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'students scores') }}</title>

    <!-- Bootstrap CSS (from CDN) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    @yield('style')

    <style>
        .form_shadow {
            font-size: 13px;
            line-height: 20px;
            flex: 1;
            padding: 24px;
            /* 1.5rem = 24px, 3rem = 48px */
            padding-bottom: 48px;
            background-color: white;
            color: black;
            /* Default text color */
            box-shadow: inset 0px 0px 0px 1px rgba(26, 26, 0, 0.16);
            border-bottom-left-radius: 0.5rem;
            /* 8px */
            border-bottom-right-radius: 0.5rem;
            /* 8px */
            border-top-left-radius: 1.25rem;
            /* 20px */
            border-top-right-radius: 0;
        }

        /* Dark mode overrides */
        .dark .my-custom-div {
            background-color: #161615;
            color: #EDEDEC;
            box-shadow: inset 0px 0px 0px 1px #fffaed2d;
        }

        @media (min-width: 1024px) {

            /* lg: */
            .my-custom-div {
                padding: 80px;
                /* 5rem = 80px */
                border-top-left-radius: 20px;
                /* 1.25rem = 20px */
                border-top-right-radius: 20px;
                /* 1.25rem = 20px */
                border-bottom-right-radius: 0;
            }
        }
    </style>

</head>