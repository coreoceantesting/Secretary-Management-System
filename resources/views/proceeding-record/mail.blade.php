<table border="1">
    <thead>
        <tr>
            <th>Meeting</th>
            <td>{{ $data?->meeting?->name }}</td>
        </tr>
    </thead>
    <tbody>
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
        <tr>
            <th>Remark</th>
            <td>{{ $data?->remark }}</td>
        </tr>

        <tr>
            <th>View File</th>
            <td><a href="{{ asset('storage/'.$data->file) }}">View</a></td>
        </tr>
    </tbody>
</table>
