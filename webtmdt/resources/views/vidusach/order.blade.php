<html>
    <head>
        <style>
            .book-table
            {
                border-collapse:collapse;
            }
            .book-table tr th
            {
                text-align:center;
            }
            .book-table tr th, .book-table tr td
            {
                border:1px solid #000;
                padding:3px;
            }
        </style>
    </head>
    <body>
    <div style='text-align:center;font-weight:bold;color:#15c;'>
        THÔNG TIN ĐƠN HÀNG
    </div>

    <table class='book-table' style='margin:0 auto; width:70%'>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tongTien = 0;
            @endphp
            @foreach($data as $key=>$row)
                <tr>
                    <td align='center'>{{$key+1}}</td>
                    <td>{{$row->tieu_de}}</td>
                    <td align='center'>{{$quantity[$row->id]}}</td>
                    <td align='center'>{{number_format($row->gia_ban,0,',','.')}}đ</td>
                    <td>
                        <form method="POST" action="{{ route('cartdelete') }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cuốn sách này không?');">
                            @csrf
                            <input type="hidden" name="id" value="{{ $row->id }}">
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @php
                $tongTien +=$quantity[$row->id]*$row->gia_ban;
                @endphp
            @endforeach
            <tr>
                <td colspan='3' align='center'><b>Tổng cộng</b></td>
                <td align='center'><b>{{number_format($tongTien,0,',','.')}}đ</b></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>