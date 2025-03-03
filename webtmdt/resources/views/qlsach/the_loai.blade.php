<html>
<head>
    <style>
        .book-table{
            border-collapse:collapse;
        }
        .book-table td, .book-table th{
            border:1px solid #000;
        }
    </style>
</head>
<body>
    <table class="book-table">
        <tr>
            <th>Mã thể loại</th>
            <th>Tên thể loại</th>
        </tr>
        @foreach($the_loai_sach as $row)
        <tr>
            <td>{{$row->id}}</td>
            <td>{{$row->ten_the_loai}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>