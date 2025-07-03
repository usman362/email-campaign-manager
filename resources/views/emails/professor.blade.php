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

        <img src="{{ route('email.track', $trackingId) }}" width="1" height="1" style="display:none;" alt="">

</body>

</html>
