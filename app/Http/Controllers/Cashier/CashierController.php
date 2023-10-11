<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Category;
use App\Models\Menu;
use App\Models\SaleDetail;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class CashierController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('cashier.index')->with('categories', $categories);
    }
    public function getTables()
    {
        $tables = Table::all();
        $html = '';
        foreach ($tables as $table) {
            $html .= '<div class="col-md-2 mb-4">';
            $html .= '<button class="btn btn-primary btn-table" data-id="' . $table->id . '" data-name="' . $table->name . '"> 
            <img class="img-fluid" src="' . url("/images/table.png") . '"/>';
            if($table->status == 'available') {
                $html .= '<span class="bg-success">' . $table->name . '</span>';
            } else {
                $html .= '<span class="bg-danger">' . $table->name . '</span>';
            }
            
          $html.='</button>';

            $html .= '</div>';
        }
        return $html;
    }
    public function getMenuByCategory($category_id)
    {
        $menus = Menu::where('category_id', $category_id)->get();
        $html = '';
        foreach ($menus as $menu) {
            $html .= '<div class="col-md-3 text-centered ">';
            $html .= '<a class="btn btn-outline-secondary btn-menu" data-id="' . $menu->id . '">
            <img class="img-fluid"  src="' . url('/menu_image/' . $menu->image) . '" />
            <br>
            ' . $menu->name . '
            <br>
            $' . number_format($menu->price) . '

          </a>';

            $html .= '</div>';
        }
        return $html;

    }
    public function orderFood(Request $request)
    {
        $user = Auth::user();
        $menu = Menu::find($request->menu_id);
        $table_id = $request->table_id;
        $table_name = $request->table_name;
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();
        // if there is no sale created then create a sale record
        if (!$sale) {
            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();
            $sale_id = $sale->id;
            // update table status 
            $table = Table::find($table_id);
            $table->status = "unavailable";
            $table->save();
        } else {
            //if there is a sale in the selected table 
            $sale_id = $sale->id;
        }
        // add ordered menu to the sales detail table
        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->menu_id = $menu->id;
        $saleDetail->menu_name = $menu->name;
        $saleDetail->menu_price = $menu->price;
        $saleDetail->quantity = $request->quantity;
        $saleDetail->save();
        //update total price in the sales table
        $sale->total_price = $sale->total_price + ($request->quantity * $menu->price);
        $sale->save();
      
        $html=$this->geSailDetails($sale_id);
        return $html; // for testing
    }
    public function getSailDetailsByTable($table_id){
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();
        $html='';
        if($sale){
            $sale_id = $sale->id;
            $html .= $this->geSailDetails($sale_id);
        } else {
            $html.="Not found any sale details for the selected table";
        }
        
        return $html;
        
    }
    public function confirmOrder(Request $request) {
        $html = '';
        try {
            SaleDetail::where('sale_id', $request->sale_id)->update(['status'=>'confirm']);
            $html .= $this->geSailDetails($request->sale_id);
        } catch(QueryException $e) {
            $html .= 'There sale was not confirmed please try again';
        }
        
        return $html;
    }
    public function deleteOrderDetail(Request $request) {
        $html = '';
        try {
           $saleDetail = SaleDetail::find($request->sale_detail_id);
           $sale_id = $saleDetail->sale_id;
           $menu_price = ($saleDetail->menu_price * $saleDetail->quantity);
           $saleDetail->delete();
           //update total price
           $sale = Sale::find($sale_id);
           $sale->total_price = $sale->total_price - $menu_price;
           $sale->save();

           $html .= $this->geSailDetails($sale_id);
        } catch(QueryException $e) {
            $html .= 'The order detail was not successfuly deleted';
        }
        
        return $html;
    }
    public function savePayment(Request $request) {
        $sale = Sale::find($request->sale_id );
        $sale->total_recieved = $request->received_amount;
        $sale->change = $request->received_amount - $sale->total_price;
        $sale->payment_type = $request->payment_type;
        $sale->sale_status = 'paid';
        $sale->save();
        //update the table to be available
        $table = Table::find($sale->table_id);
        $table->status = 'available';
        $table->save();
        return "/cashier/showReceipt/".$request->sale_id;

    }
    public function showReceipt($sale_id) {
        $sale =Sale::find($sale_id);
        $saleDetails = SaleDetail::where('sale_id',$sale_id);
        return view('cashier.showReceipt')->with('sale',$sale)->with('saleDetails',$saleDetails);
    }
    private function geSailDetails($sale_id){
          // list all sales details
          $html = '<p>Sale ID:' . $sale_id . ' <p/>';
          $saleDetails = SaleDetail::where('sale_id', $sale_id)->get();
          $html .= '<div class="table-responsive-md" style="overflow-y:scroll;height:400px;border:1px solid #343A40">
          <table class="table table-stripped table-dark">
          <thead>
          <tr>
          <th scope="col">ID</th>
          <th scope="col">Menu</th>
          <th scope="col">Quantity</th>
          <th scope="col">Price</th>
          <th scope="col">Total</th>
          <th scope="col">Status</th>
          </tr>
          
          </thead>
          <tbody>
          <tr>';
          $showBtnPayment = true;
          foreach($saleDetails as $saleDetail){
              $html .='<tr>';
              $html.='<td>'.$saleDetail->menu_id.'</td>';
              $html.='<td>'.$saleDetail->menu_name.'</td>';
              $html.='<td>'.$saleDetail->quantity.'</td>';
              $html.='<td>'.$saleDetail->menu_price.'</td>';
              $html.='<td>'.($saleDetail->menu_price * $saleDetail->quantity).'</td>';
              if($saleDetail->status == 'noConfirm'){
                $showBtnPayment = false;
                $html .= '<td><a class="btn btn-danger btn-delete-sale-detail" data-id="'.$saleDetail->id.'"><i class="fas fa-trash-alt"></i></a><td/>';
            }else {
                $html .= '<td><i class="fas fa-check-circle"></i><td/>';
            }
              $html.='</tr>';
          }
         
          $html.='
          
          </tbody>
          </table>
          
          </div>';
          $sale =Sale::find($sale_id);
          $html .= '<hr>';
          $html .= '<h3>Total Amount: $'.$sale->total_price.'</h3>';
          if ($showBtnPayment) {
            $html .= '<button data-id='.$sale_id.' class="btn btn-success btn-block btn-payment" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModal"
            data-totalamount="'.$sale->total_price.'"
            >Payment</button>';
          } else {
            $html .= '<button data-id='.$sale_id.' class="btn btn-warning btn-block btn-confirm-order">Confrim Order</button>';
          }


          return $html;
    }
}