<x-account-panel>
    <div class="panel panel-default" style="width:50%; margin:0 auto;">
        <div class="panel-body">
            <form action="{{route('booksave',['action'=>$action])}}" method = "post" enctype="multipart/form-data">
                <div style='text-align:center;font-weight:bold;color:#15c;'>THÊM THÔNG TIN SÁCH</div>
                <label>Tiêu đề</label>
                <input type='text' class='form-control form-control-sm' name='tieu_de' value="">
                <label>Nhà xuất bản</label>
                <input type='text' class='form-control form-control-sm' name='nha_xuat_ban' value="">
                <label>Nhà cung cấp</label>
                <input type='text' class='form-control form-control-sm' name='nha_cung_cap' value="">
                <label>Tác giả</label>
                <input type='text' class='form-control form-control-sm' name='tac_gia' value="">
                <label>Hình thức bìa</label>
                <input type='text' class='form-control form-control-sm' name='hinh_thuc_bia' value="">
                <label>Giá bán</label>
                <input type='text' class='form-control form-control-sm' name='gia_ban' value="">
                <label>Thể loại</label>
                <select name='id_the_loai' class='form-control form-control-sm'>
                    @foreach($the_loai as $row)
                    <option value='{{$row->id}}'>
                        {{$row->ten_the_loai}}
                    </option>
                    @endforeach
                </select>
                <label>Ảnh đại diện</label><br>
                <input type="file" name="file_anh_bia" accept="image/*" class="form-control-file">
                {{ csrf_field() }}
                <div style='text-align:center;'><input type='submit' class='btn btn-primary mt-1' value='Lưu'></div>
            </form>
            @if ($errors->any())
            <div style='color:red; margin:0 auto'>
            <div >
            {{ __('Whoops! Something went wrong.') }}
            </div>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif

        </div>
    </div>
</x-account-panel>