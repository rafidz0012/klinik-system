<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Wilayah</title>
</head>
<body>
    <h2>Daftar Wilayah</h2>
    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Provinsi</th>
                <th>Kota / Kabupaten</th>
                <th>Provinsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wilayahs as $index => $w)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $w->provinsi }}</td>
                    <td>{{ $w->kota }}</td>
                    <td>{{ $w->kecamatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
