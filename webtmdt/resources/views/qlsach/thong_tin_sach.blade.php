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
            <th>Tiêu đề</th>
            <th>Tác giả</th>
        </tr>
        @foreach($sach as $row)
        <tr>
            <td>{{$row->tieu_de}}</td>
            <td>{{$row->tac_gia}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>