<!DOCTYPE html>
<html>
<head>
    <title>Upload JSON Data</title>
</head>
<body>
    <form action="/index-data" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="json_file">
        <button type="submit">Upload</button>
    </form>
</body>
</html>