<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Income Report</title>

    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
</head>
<body>
    <h3 class="text-center">Income Report</h3>
    <h4 class="text-center">
        Date {{ tanggal_indonesia($awal, false) }}
        s/d
        Date {{ tanggal_indonesia($akhir, false) }}
    </h4>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>Date</th>
                <th>Sale</th>
                <th>Purchase</th>
                <th>Expenses</th>
                <th>Income</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>