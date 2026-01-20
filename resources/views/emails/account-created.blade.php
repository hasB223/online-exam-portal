<!DOCTYPE html>
<html>
    <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #0f172a;">
        <h2>Welcome to Online Exam Portal</h2>
        <p>Your account has been created.</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        @if ($className)
            <p><strong>Class:</strong> {{ $className }}</p>
        @endif
        <p>To set your password, use the link below:</p>
        <p><a href="{{ $setPasswordUrl }}">{{ $setPasswordUrl }}</a></p>
        <p>Login URL: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
    </body>
</html>
