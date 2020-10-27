<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Documents</title>
    <link rel="stylesheet" type="text/css" href="{{core_assets('api/ui.css')}}" >
    <link rel="stylesheet" type="text/css" href="{{core_assets('api/theme-flattop.css')}}" >
</head>

<body onload="render()">
<div id="swagger-ui"></div>
<script src="{{core_assets('api/ui-bundle.js')}}"></script>
<script src="{{core_assets('api/ui-preset.js')}}"></script>

<script>
    function render() {
        const ui = SwaggerUIBundle({
            url: "{{route('swagger-api')}}",
            dom_id: "#swagger-ui",
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIBundle.SwaggerUIStandalonePreset
            ]
        });
    }
</script>
</body>
</html>