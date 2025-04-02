<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    function laythongtintheloai()
    {
        $the_loai_sach = Category::all();
        return view("qlsach.the_loai",compact("the_loai_sach"));
    }
    function laythongtinsach()
    {
        $sach = Book::select("tieu_de","tac_gia")
                ->where("nha_xuat_ban","Văn Học")
                ->where("gia_ban",">=",50000)
                ->where("gia_ban","<=",90000)->get();
        return view("qlsach.thong_tin_sach",compact("sach"));
    }
    function nhapdulieu()
    {
        return view("qlsach.nhap_du_lieu");
    }
    function luudulieu(Request $request)
    {
        $ids=$request->input("id"); //["5","6"]
        $ten_the_loais=$request->input("ten_the_loai"); //["Viễn tưởng","Truyện dài tập"]
        
        $data=[];
        foreach($ids as $key => $value)
        {
            $data[] = ["id"=>$value,"ten_the_loai"=>$ten_the_loais[$key]];
        }
        DB::table("the_loai"->insert($data));
        echo "Thêm thành công";
    }

    public function booklist(){
        $data = DB::table("sach")->get();
        return view("vidusach.book_list",compact("data"));
        }
    
    public function bookcreate(){
        $the_loai = DB::table("the_loai")->get();
        $action = "add";
        return view("vidusach.book_form",compact("the_loai","action"));
        }

    public function booksave($action, Request $request)
    {
    $request->validate([
    'tieu_de' => ['required', 'string', 'max:200'],
    'nha_cung_cap' => ['required', 'string', 'max:50'],
    'nha_xuat_ban' => ['required', 'string', 'max:50'],
    'tac_gia' => ['required', 'string', 'max:50'],
    'hinh_thuc_bia' => ['required', 'string', 'max:50'],
    'gia_ban' => ['required', 'numeric'],
    'id_the_loai' => ['required', 'max:3'],
    'file_anh_bia' => ['nullable','image']
    ]);
    $data = $request->except("_token");

    if($action=="edit")
    $data = $request->except("_token", "id");

    if($request->hasFile("file_anh_bia"))
    {
    $fileName = $request->input("tieu_de") ."_".rand(1000000,9999999).'.' . $request->file('file_anh_bia')->extension();
    $request->file('file_anh_bia')->storeAs('public/book_image', $fileName);
    $data['file_anh_bia'] = $fileName;
    }
    $message = "";
    if($action=="add")
    {
    DB::table("sach")->insert($data);
    $message = "Thêm thành công";
    }

    else if($action=="edit")
    {
    $id = $request->id;
    DB::table("sach")->where("id",$id)->update($data);
    $message = "Cập nhật thành công";
    }

    return redirect()->route('booklist')->with('status', $message);
    }

    public function bookedit($id)
    {
        $action = "edit";
        $the_loai = DB::table("the_loai")->get();
        $sach = DB::table("sach")->where("id",$id)->first();
        return view("vidusach.book_form",compact("the_loai","action","sach"));
    }

    public function bookdelete(Request $request)
    {
        $id = $request->id;
        DB::table("sach")->where("id",$id)->delete();
        return redirect()->route('booklist')->with('status', "Xóa thành công");
    }

    public function cartadd(Request $request)
    {
        $request->validate([
        "id"=>["required","numeric"],
        "num"=>["required","numeric"]
        ]);
        $id = $request->id;
        $num = $request->num;
        $total = 0;
        $cart = [];
        if(session()->has('cart'))
        {
        $cart = session()->get("cart");
        if(isset($cart[$id]))
        $cart[$id] += $num;
        else
        $cart[$id] = $num ;
        }
        else
        {
        $cart[$id] = $num ;
        }
        session()->put("cart",$cart);
        return count($cart);
    }

    public function order()
    {
        $cart=[];
        $data =[];
        $quantity = [];
        if(session()->has('cart'))
        {
        $cart = session("cart");
        $list_book = "";
        
        foreach($cart as $id=>$value)
        {
        $quantity[$id] = $value;
        $list_book .=$id.", ";
        }
        /*$list_book = substr($list_book, 0,strlen($list_book)-2);
        $data = DB::table("sach")->whereRaw("id in (".$list_book.")")->get();*/
        $list_book = rtrim($list_book, ", ");

        if (!empty($list_book)) {
            $data = DB::table("sach")->whereRaw("id in (".$list_book.")")->get();
        } else {
            $data = []; // Nếu giỏ hàng trống, tránh lỗi SQL
        }
        }
        return view("vidusach.order",compact("quantity","data"));
    }

    public function cartdelete(Request $request)
    {
        $request->validate([
        "id"=>["required","numeric"]
        ]);
        $id = $request->id;
        $total = 0;
        $cart = [];
        if(session()->has('cart'))
        {
        $cart = session()->get("cart");
        unset($cart[$id]);
        }
        session()->put("cart",$cart);
        return redirect()->route('order');
    }

    public function ordercreate(Request $request)
    {
        $request->validate([
        "hinh_thuc_thanh_toan"=>["required","numeric"]
        ]);
        $data = [];
        $quantity = [];
        if(session()->has('cart'))
        {
        $order = ["ngay_dat_hang"=>DB::raw("now()"),"tinh_trang"=>1,
        "hinh_thuc_thanh_toan"=>$request->hinh_thuc_thanh_toan,
        "user_id"=>Auth::user()->id];
        DB::transaction(function () use ($order) {
        $id_don_hang = DB::table("don_hang")->insertGetId($order);
        $cart = session("cart");
        $list_book = "";
        $quantity = [];
        foreach($cart as $id=>$value)
        {
        $quantity[$id] = $value;
        $list_book .=$id.", ";
        }
        $list_book = substr($list_book, 0,strlen($list_book)-2);
        $data = DB::table("sach")->whereRaw("id in (".$list_book.")")->get();
        $detail = [];
        foreach($data as $row)
        {
        $detail[] = ["ma_don_hang"=>$id_don_hang,"sach_id"=>$row->id,
        "so_luong"=>$quantity[$row->id],"don_gia"=>$row->gia_ban];
        }
        DB::table("chi_tiet_don_hang")->insert($detail);
        session()->forget('cart');
        });
        }
        return view("vidusach.order", compact('data','quantity'));
    }


    
    public function bookview(Request $request)
    {
        $the_loai = $request->input("the_loai");
        $data = [];
        if($the_loai!="")
        $data = DB::select("select * from sach where the_loai = ?",[$the_loai]);
        else
        $data = DB::select("select * from sach order by gia_ban asc limit 0,10");
        return view("vidusach.bookview", compact("data"));
    }
        
}