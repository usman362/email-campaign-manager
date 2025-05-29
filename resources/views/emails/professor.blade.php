<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $template->subject ?? 'Email' }}</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px;">

    <div style="background: #ffffff; padding: 20px; border-radius: 8px;">
        {{-- Replace placeholders dynamically --}}
        {!! str_replace(['{name}', '{sender_name}'], [$professor->name ?? 'Professor', env('APP_NAME')], $content) !!}

    </div>

</body>

</html>
