<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%
        }

        th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h3>Goshwara View Datetime</h3>
    <h5>{{ $agenda->mayor_view_datetime }}</h5>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th>Department</th>
                <th>Goshwara</th>
                <th>Subject</th>
                <th>Sub Subject</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agenda?->assignGoshwaraToAgenda as $goshwara)
                <tr>
                    <td>{{ $goshwara?->goshwara?->department?->name }}</td>
                    <td>{{ $goshwara?->goshwara?->name }}</td>
                    <td>{{ $goshwara?->goshwara?->subject }}</td>
                    <td>{{ $goshwara?->goshwara?->sub_subject }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>