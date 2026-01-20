<!DOCTYPE html>
<html>
    <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #0f172a;">
        <h2>Your account details were updated</h2>
        <p>The admin updated your account details.</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        @if ($className)
            <p><strong>Class:</strong> {{ $className }}</p>
        @endif
        <p>Login URL: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
    </body>
</html>
