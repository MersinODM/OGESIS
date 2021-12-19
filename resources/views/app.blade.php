<!DOCTYPE html>
<html lang="tr" style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Parametrik Kurum Adı</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.3/katex.min.css" integrity="sha512-j3Y0TJLzsVaZJ0duMfC+JTiY8alAIy6ElMsJJA5It6h4tVA22wSg5EeAhmvosZvYFSgE0zsFr9SQMykhMV/ixw==" crossorigin="anonymous" />--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.3/contrib/copy-tex.min.css" integrity="sha512-zpYS5KnYzWXUCp2eKVtNDIBAVxhAGbhXOCnm4eZUDsYqcveMwokhfV5FpNT1r23pr3QLb1Xsw+zJ7eqAZAdBag==" crossorigin="anonymous" />--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div id="app"></div>
<script defer src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script defer type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.js"></script>
{{--<script defer src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.3/katex.min.js" integrity="sha512-eSmzRgPuKNqkY2kJPalDTh4jg63opCXWaRMT6nwVNXXUuDjK+i2pxK63q1tka7uU8b3u33wAg+wCAV4fLwyHRw==" crossorigin="anonymous"></script>--}}
{{--<script defer src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.3/contrib/mhchem.min.js" integrity="sha512-oGRFOTIYLFCM52dbNUeknDsKpeFmjrqvHTHR7mSDF9koxr+9nA4xAZ/qd1RlySCU/BS5HvHQMty0VAikZtfMqg==" crossorigin="anonymous"></script>--}}
{{--<script defer src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.3/contrib/auto-render.min.js" integrity="sha512-CzIEOUs11SQ7tekLhEe5gil9kDip4RTJZVf7pSjlxOdVaYYHEcQflhunPz2Q/onNC4slL9jpKjvNgzPAAxEpew==" crossorigin="anonymous"></script>--}}
{{--<script defer src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.3/contrib/copy-tex.min.js" integrity="sha512-69oQlJyjN7VLQDagAaaOrUfgp66VdWTi0ZBy7aoAraAH8H2C13YM+JAPR0N3KBW7G82gDnvcb0l953DOi0GyoQ==" crossorigin="anonymous"></script>--}}
{{--<script defer src="{{ asset('js/app/ckeditor/ckeditor.js') }}" type="application/javascript"></script>--}}
<script defer src="{{ mix('js/manifest.js') }}" type="application/javascript"></script>
<script defer src="{{ mix('js/vendor.js') }}" type="application/javascript"></script>
<script defer src="{{ mix('js/vendor~utils-1.js') }}" type="application/javascript"></script>
<script defer src="{{ mix('js/vendor~utils-2.js') }}" type="application/javascript"></script>
<script defer src="{{ mix('js/vendor~utils-3.js') }}" type="application/javascript"></script>
<script defer src="{{ mix('js/app.js') }}" type="application/javascript"></script>
</body>
</html>
