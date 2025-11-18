<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $landingPage->name }}</title>
    <style>{!! $landingPage->css_content !!}</style>
</head>
<body>
    {!! $landingPage->html_content !!}
    <script>{!! $landingPage->js_content !!}</script>
</body>
</html>
