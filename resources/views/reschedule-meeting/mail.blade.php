<table border="1">
    <thead>
        <tr>
            <th>Agenda</th>
            <td>{{ $oldData?->agenda?->subject }}</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Meeting</th>
            <td>{{ $oldData?->meeting?->name }}</td>
        </tr>
        <tr>
            <th>Old Date</th>
            <td>{{ date('d-m-Y', strtotime($oldData?->date)) }}</td>
        </tr>
        <tr>
            <th>Old Time</th>
            <td>{{ date('H:i A', strtotime($oldData?->time)) }}</td>
        </tr>
        <tr>
            <th>Old Place</th>
            <td>{{ $oldData?->data?->place }}</td>
        </tr>
        <tr>
            <th>New Date</th>
            <td>{{ date('d-m-Y', strtotime($newData?->date)) }}</td>
        </tr>
        <tr>
            <th>New Time</th>
            <td>{{ date('H:i A', strtotime($newData?->time)) }}</td>
        </tr>
        <tr>
            <th>New Place</th>
            <td>{{ $newData?->data?->place }}</td>
        </tr>
    </tbody>
</table>
