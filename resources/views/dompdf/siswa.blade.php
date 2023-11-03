<html>
<head>
    <title>Data siswa</title>
</head>
<body>
    <h1>Data siswa</h1>
    <table>
        <thead>
            <tr>
                <th>nama</th>
<th>nisn</th>
<th>alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswas as $siswa)
                <tr>
                    <td>{{ $siswa->nama }}</td>
<td>{{ $siswa->nisn }}</td>
<td>{{ $siswa->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
