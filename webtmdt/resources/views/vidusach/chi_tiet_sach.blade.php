<x-book-layout>
    <x-slot name='title'>
       Chi tiết Sách
    </x-slot>
    <style>
        .info
        {
            display:grid;
            grid-template-columns:repeat(2,30% 70%);
        }
    </style>
    <h4>{{$data->tieu_de}}</h4>
    <div class='info'>
        <div>
            <img src="{{asset('book_image/'.$data->file_anh_bia)}}" width="200px" height="200px">
        </div>
        <div>
            Nhà cung cấp: <b>{{$data->nha_cung_cap}}</b><br>
            Nhà xuất bản: <b>{{$data->nha_xuat_ban}}</b><br>
            Tác giả: <b>{{$data->tac_gia}}</b><br>
            Hình thức bìa: <b>{{$data->hinh_thuc_bia}}</b><br>
            <div class='mt-1'>
                Số lượng mua:
                <input type='number' id='product-number' size='5' min="1" value="1">
                <button class='btn btn-success btn-sm mb-1' id='add-to-cart'>Thêm vào giỏ hàng</button>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <b>Mô tả:</b><br>
            {{$data->mo_ta}}
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#add-to-cart").click(function(){
                id = "{{$data->id}}";
                num = $("#product-number").val()
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"{{route('cartadd')}}",
                    data:{"_token":"{{csrf_token() }}","id":id, "num":num},
                    beforeSend:function(){

                    },

                    success:function(data){
                        $("#cart-number-product").html(data);
                    },
                    error: function (xhr, status, error){

                    },
                    complete: function (xhr, status){
                        
                    }
                });
            });
        });
    </script>
</x-book-layout>