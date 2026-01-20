<!DOCTYPE html>
<html>
    <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #0f172a;">
        <h2>New exam published</h2>
        <p><strong>{{ $exam->title }}</strong> is now available.</p>
        <p><strong>Subject:</strong> {{ $exam->subject?->name ?? '-' }}</p>
        <p><strong>Duration:</strong> {{ $exam->duration_minutes ? $exam->duration_minutes.' minutes' : 'No limit' }}</p>
        <p>View the exam in your dashboard:</p>
        <p><a href="{{ $examsUrl }}">{{ $examsUrl }}</a></p>
    </body>
</html>
