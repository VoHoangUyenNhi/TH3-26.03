<x-book-layout>
    <x-slot name='title'>
        Sách
    </x-slot>
    <style>
        .navbar {
        background-color: #ff5850;
        font-weight:bold;
        }
        .nav-item a {
        color: #fff!important;
        }
        .navbar-nav {
        margin:0 auto;
        }
        .list-book{
        display:grid;
        grid-template-columns:repeat(4,25%);
        }
        .book {
        margin:10px;
        text-align:center;
        }
    </style>
    <div class='list-book'>
        @foreach($data as $row)
        <div class='book'>
            <a href="{{url('sach/chitietsach/'.$row->id)}}">
                <img src="{{asset('book_image/'.$row->file_anh_bia)}}" width='200px'
                height='200px'><br>
                <b>{{$row->tieu_de}}</b><br/>
                <i>{{number_format($row->gia_ban,0,",",".")}}đ</i>
            </a>
        </div>
        @endforeach
    </div>
</x-book-layout>

