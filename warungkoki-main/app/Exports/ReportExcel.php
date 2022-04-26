<?php

namespace App\Exports;

use App\TransaksiDetails;
use App\Transaksi;
USE DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ReportExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $dari;
    private $sampai;
    private $type;

    public function __construct($dari,$sampai,$type,$id)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
        $this->type = $type;
        $this->id = $id;
    }
    
    public function view(): View
    {


        if($this->type == 'all'){

            $reedems = TransaksiDetails::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post','product.name as prod_name','transaction_details.qty','users.name as user_name','product.harga','posts.harga_act')
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->whereBetween('transactions.created_at', [$this->dari, $this->sampai])
            ->where([
                ['posts.user_id', $this->id],
                ['transactions.status', '=', 'APPROVED'],
                ['transactions.type', '=', 'out'],
            ])
            ->get();

            $penjualans = Transaksi::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post', 'order_details.amount','orders.type_bayar','users.name as user_name','order_details.qty','product.name as prod_name')
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->leftJoin("order_details", "orders.id", "=", "order_details.order_id")
            ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->whereBetween('transactions.created_at', [$this->dari, $this->sampai])
            ->where([
                ['posts.user_id', $this->id],
                ['transactions.status', '=', 'APPROVED'],
                ['transactions.type', '=', 'in'],
            ])
            ->get();

        } else if($this->type == 'penjualan'){

            $penjualans = Transaksi::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post', 'order_details.amount','orders.type_bayar','users.name as user_name','order_details.qty','product.name as prod_name')
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->leftJoin("order_details", "orders.id", "=", "order_details.order_id")
            ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->whereBetween('transactions.created_at', [$this->dari, $this->sampai])
            ->where([
                ['posts.user_id', $this->id],
                ['transactions.status', '=', 'APPROVED'],
                ['transactions.type', '=', 'in'],
            ])
            ->get();

            $reedems = '';

        } else {

            $reedems = TransaksiDetails::select('transactions.*', 'posts.name as post_name', 'posts.type as type_post','product.name as prod_name','transaction_details.qty','users.name as user_name','product.harga','posts.harga_act')
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->whereBetween('transactions.created_at', [$this->dari, $this->sampai])
            ->where([
                ['posts.user_id', $this->id],
                ['transactions.status', '=', 'APPROVED'],
                ['transactions.type', '=', 'out'],
            ])
            ->get();

            $penjualans = '';

        }

        return view('content.report.printexcel', ['penjualans' => $penjualans, 'reedems' => $reedems, 'type' => $this->type]);
    }
}
