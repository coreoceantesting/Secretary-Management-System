<table border="1">
    <thead>
        <tr>
            <th>Agenda</th>
            <td>{{ $data?->agenda?->name }}</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Meeting</th>
            <td>{{ $data?->meeting?->name }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ date('d-m-Y', strtotime($data?->date)) }}</td>
        </tr>
        <tr>
            <th>Time</th>
            <td>{{ date('H:i A', strtotime($data?->time)) }}</td>
        </tr>
        <tr>
            <th>Place</th>
            <td>{{ $data?->data?->place }}</td>
        </tr>
    </tbody>
</table>
