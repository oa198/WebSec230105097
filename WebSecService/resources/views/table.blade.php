<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multiplication Tables</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script><link href="public/css/bootstrap.min.css" rel="stylesheet">
    <script> src="public/js/bootstrap.bundle.min.js"</script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Multiplication Tables (1 to 10)</h2>

        <div class="row">
            @for ($i = 1; $i <= 10; $i++)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            Table of {{ $i }}
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @for ($j = 1; $j <= 10; $j++)
                                    <li class="list-group-item">{{ $i }} × {{ $j }} = {{ $i * $j }}</li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</body>
</html>
