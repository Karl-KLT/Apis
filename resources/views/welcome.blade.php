<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>server . . .</title>
</head>
<body>
    <div class="vh-100 w-100 d-flex justify-content-center align-items-center">
        @if (env('SERVER'))
            <div class="badge bg-dark">
                ur server is running . . .
            </div>
        @else
            <div class="badge bg-danger">
                ur server is not running
            </div>
        @endif
    </div>
</body>
</html>
