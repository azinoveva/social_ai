<!DOCTYPE html>
<html>
<head>
    <title>Upload JSON Data</title>
</head>
<body>
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
    @endif
</body>
</html>