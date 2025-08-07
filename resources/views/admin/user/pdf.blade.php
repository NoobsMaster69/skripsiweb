<h1 align="center">Data User</h1>
<h3 align="center">Tanggal : {{ $tanggal }}</h3>
<h3 align="center">Pukul : {{ $jam }}</h3>

<table width="100%" border="1px" style="border-collapse:collapse">
    <thead>

        <tr>
            <th width="20" align="center">No</th>
            <th width="20" align="center">Nama</th>
            <th width="20" align="center">Email</th>
            <th width="20" align="center">Jabatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $item)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">{{ $item->nama }}</td>
            <td align="center">{{ $item->email }}</td>
            <td align="center">{{ $item->jabatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

