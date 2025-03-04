<form action="{{ url('qlsach/luudulieu') }}" method = "get">
    <table>
        <tr>
            <th>ID</th>
            <th>Tên thể loại</th>
        </tr>
        <tr>
            <td><input type='text' name='id[]'></td>
            <td><input type='text' name='ten_the_loai[]'></td>
        </tr>
        <tr>
            <td><input type='text' name='id[]'></td>
            <td><input type='text' name='ten_the_loai[]'></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" value="Lưu">
            </td>
        </tr>
    </table>
    {{ csrf_field() }}
</form>