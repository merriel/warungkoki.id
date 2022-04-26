<?php

namespace App\Exports;

use App\TransaksiDetails;
use App\Transaksi;
USE DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class TransactionExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $dari;
    private $sampai;
    private $type;

    public function __construct($dari,$sampai,$type,$user)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
        $this->type = $type;
        $this->user = $user;
    }
    
    public function view(): View
    {
        if($this->type == 'all'){

            $reedems = TransaksiDetails::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post','product.name as prod_name','transaction_details.qty','wilayah.name as wilayah_name', 'transaction_details.product_id', 'posts.harga_act')
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->whereBetween('transactions.created_at', [$this->dari." 00:00:00", $this->sampai." 23:59:59"])
            ->where([
                ['transactions.user_id', $this->user],
                ['transactions.type', '=', 'out'],
            ])
            ->get();

            $pembelians = Transaksi::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post', 'order_details.amount','orders.type_bayar','wilayah.name as wilayah_name','order_details.qty')
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->leftJoin("order_details", "orders.id", "=", "order_details.order_id")
            ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->whereBetween('transactions.created_at', [$this->dari." 00:00:00", $this->sampai." 23:59:59"])
            ->where([
                ['transactions.user_id', $this->user],
                ['transactions.type', '=', 'in'],
            ])
            ->get();

        } else if($this->type == 'pembelian'){

            $pembelians = Transaksi::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post', 'order_details.amount','orders.type_bayar','wilayah.name as wilayah_name','order_details.qty')
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->leftJoin("order_details", "orders.id", "=", "order_details.order_id")
            ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->whereBetween('transactions.created_at', [$this->dari." 00:00:00", $this->sampai." 23:59:59"])
            ->where([
                ['transactions.user_id', $this->user],
                ['transactions.type', '=', 'in'],
            ])
            ->get();

            $reedems = '';

        } else {

            $reedems = TransaksiDetails::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post','product.name as prod_name','transaction_details.qty','wilayah.name as wilayah_name', 'transaction_details.product_id', 'posts.harga_act')
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->whereBetween('transactions.created_at', [$this->dari." 00:00:00", $this->sampai." 23:59:59"])
            ->where([
                ['transactions.user_id', $this->user],
                ['transactions.type', '=', 'out'],
            ])
            ->get();

             $pembelians = '';

        }

        return view('content.transaksi.printexcel', ['reedems' => $reedems, 'pembelians' => $pembelians, 'type' => $this->type]);
    }
}
