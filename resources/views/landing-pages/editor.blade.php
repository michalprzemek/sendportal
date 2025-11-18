<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Landing Page Editor</title>
    <link rel="stylesheet" href="{{ asset('vendor/grapesjs/grapes.min.css') }}">
    <script src="{{ asset('vendor/grapesjs/grapes.min.js') }}"></script>
    <script src="{{ asset('vendor/grapesjs/grapesjs-preset-webpage.min.js') }}"></script>
    <script src="{{ asset('vendor/grapesjs/grapesjs-custom-code.min.js') }}"></script>
    <script src="{{ asset('vendor/grapesjs/grapesjs-blocks-basic.min.js') }}"></script>
</head>
<body>

<div id="gjs"></div>

<script type="text/javascript">
    const editor = grapesjs.init({
        container: '#gjs',
        fromElement: true,
        height: '100vh',
        width: 'auto',
        storageManager: {
            type: 'remote',
            stepsBeforeSave: 1,
            url: "{{ route('api.landing-pages.update', $landingPage->id) }}",
            autosave: true,
            contentType: 'application/json',
            params: { _token: '{{ csrf_token() }}' },
            onStore: (data, editor) => {
                const html = editor.getHtml();
                const css = editor.getCss();
                const js = editor.getJs();
                return { 'gjs-html': html, 'gjs-css': css, 'gjs-js': js, ...data };
            },
        },
        plugins: [
            'gjs-preset-webpage',
            'gjs-custom-code',
            'grapesjs-blocks-basic',
        ],
        pluginsOpts: {
            'gjs-preset-webpage': {},
            'gjs-custom-code': {},
            'grapesjs-blocks-basic': {},
        },
        parser: {
            optionsHtml: {
                allowScripts: true,
            },
        },
    });

    editor.setComponents(`{!! $landingPage->html_content !!}`);
    editor.setStyle(`{!! $landingPage->css_content !!}`);
    const root = editor.DomComponents.getWrapper();
    const script = root.append({
        type: 'script',
        content: `{!! $landingPage->js_content !!}`,
    });

</script>
</body>
</html>
