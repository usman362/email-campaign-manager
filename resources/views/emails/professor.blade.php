<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $template->subject ?? 'Email' }}</title>
</head>

<body>

    <div style="padding:20px 0px">
        {{-- Replace placeholders dynamically --}}
        {!! str_replace(['{name}', '{sender_name}'], [$professor->name ?? 'Professor', env('APP_NAME')], $content) !!}

    </div>

</body>

</html>
