<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" />
    <title> CLP - @yield('htmlheader_title', 'Lending Project') </title>
    <meta property="og:image" content="{{ url('/img/logo.png') }}" />
    <meta content="Crypto Lending is a decentralized peer-to-peer lending platform that applies Blockchain technology and CLP coin as material.."
        property="og:description" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="google-site-verification" content="YoKxcLBO-buCnESjlFmmFeZqaNULyT4Z88cVN4OLqN0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/css/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ url('/js/sweetalert.min.js') }}"></script>
    @yield('custome_css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.trans = @php
            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
            echo json_encode($trans);
        @endphp
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src ="https://www.googletagmanager.com/gtag/js?id=UA-107668853-2">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-107668853-2');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
            n.queue = []; t = b.createElement(e); t.async = !0;
            t.src = v; s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '130921384272682');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height ="1"  width="1"  style="display:none"
                      src="https://www.facebook.com/tr?id=130921384272682&ev=PageView&noscript=1" />
    </noscript>
        <!-- End Facebook Pixel Code -->
</head>
