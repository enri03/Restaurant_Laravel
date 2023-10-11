@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" id="table-detail"></div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <button class="btn btn-primary btn-block" id="btn-show-tables">View All Tables</button>
                <div id="selected-table"></div>
                <div id="order-detail"></div>
            </div>
            <div class="col-md-7">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @foreach ($categories as $category)
                            <li class="nav-item">
                                <a class="btn nav-link text-dark" aria-current="page" data-id="{{ $category->id }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </div>
                </nav>
                <div id="list-menu" class="row mt-2"></div>
            </div>
        </div>
    </div>  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Payment</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h3 class="total-amount"></h3>
          <h3 class="change-amount"></h3>
          <div class="input-group mb3">
            <div class="input-group-prepend ">
                <span class="input-group-text">$</span>
            </div>
            <input type="number" id="receivedAmount" class="form-control" min="0">
          </div>
          <div class="form-group">
            <label for="payment-type">Payment type</label>
            <select class="form-control " id="payment-type">
                <option value="cash">Cash</option>
                <option value="credit cart">Credit Cart</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-save-payment" disabled>Save Payment</button>
        </div>
      </div>
    </div>
  </div>
    @push('scripts')
        <script>
            var SELECTED_TABLE_ID = "";
            var SELECTED_TABLE_NAME = "";
            var SALE_ID = "";
            $(document).ready(function() {
                $("#table-detail").hide();
                //when a cashier click save paymet
                $('.btn-save-payment').click(function(){
                var  received_amount = $("#receivedAmount").val();
                var  payment_type = $('#payment-type').val();
                var  sale_id = SALE_ID;
                $.ajax({
                        type:"POST",
                        data:{
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "sale_id":sale_id,
                            "received_amount":received_amount,
                            "payment_type":payment_type
                        },
                        url:'/cashier/savePayment',
                        success: function (data) {
                            window.location.href = data;
                        }
                    })

                });
                //calculate change
                $("#receivedAmount").keyup(function(){
                  var  total_amount=$('.btn-payment').data('totalamount');
                  var  recieved_amount=$(this).val();
                  var  change_amount=recieved_amount-total_amount;
                    $('.change-amount').html('Change Amount: '+change_amount+'$');
                    //check if cashier entered the wright amount
                    if(change_amount>=0){
                        $('.btn-save-payment').prop('disabled',false);
                    }else {
                        $('.btn-save-payment').prop('disabled',true);
                    }
                })
                //when a user click on payment button
                $("#order-detail").on('click','.btn-payment',function(){
                 var   total_amount=$(this).data('totalamount')
                    $('.total-amount').html('Total Amount: '+total_amount+'$');
                    $("#receivedAmount").val('');
                    $('.change-amount').html('');
                    SALE_ID = $(this).data('id');
                })
                //Delete order details
                $("#order-detail").on('click','.btn-delete-sale-detail',function(){
                    var saleDetaillID = $(this).data('id');
                    $.ajax({
                        type:"DELETE",
                        data:{
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "sale_detail_id":saleDetaillID
                        },
                        url:'/cashier/deleteOrderDetail',
                        success: function (data) {
                            $("#order-detail").html(data);
                        }
                    })

                });          
                //confirm order
                $("#order-detail").on('click','.btn-confirm-order',function(){
                    var saleID = $(this).data('id');
                    $.ajax({
                        type:"POST",
                        data:{
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "sale_id":saleID
                        },
                        url:'/cashier/confirmOrder',
                        success: function (data) {
                            $("#order-detail").html(data);
                        }
                    })

                });
                // Create order
                $("#list-menu").on('click', '.btn-menu', function() {
                    if (SELECTED_TABLE_ID == "") {
                        alert("you need to select a table ");
                    } else {
                        var menu_id = $(this).data("id");
                        $.ajax({
                            type: "POST",
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'), 
                                "menu_id": menu_id,
                                "table_id": SELECTED_TABLE_ID,
                                "table_name": SELECTED_TABLE_NAME,
                                "quantity": 1
                            },
                            url: "/cashier/orderFood",
                            success: function(data) {
                                $("#order-detail").html(data);
                            }
                        });

                    }
                });

                // Detect table clicked with the correct class selector ".btn-table"

                $("#table-detail").on('click', '.btn-table', function() {
                    SELECTED_TABLE_ID = $(this).data("id");
                    SELECTED_TABLE_NAME = $(this).data("name");
                    $("#selected-table").html('<br><h3>Table: ' + SELECTED_TABLE_NAME + '</h3><hr>');
                    $.get("cashier/getSailDetailsByTable/"+SELECTED_TABLE_ID,function(data){
                        $("#order-detail").html(data);
                    })
                });


                //fetch menu by category
                $(".nav-link").click(function() {
                    var category_id = $(this).data("id");

                    var url = "cashier/getMenuByCategory/" + category_id;

                    $.get(url, function(data) {
                        $("#list-menu").hide();
                        $("#list-menu").html(data);
                        $("#list-menu").fadeIn('fast');
                    });
                });
                // show all tables
                $("#btn-show-tables").click(function() {
                    if ($("#table-detail").is(':hidden')) {
                        $.get("/cashier/getTable", function(data) {
                            $("#table-detail").html(data);
                            $("#table-detail").slideDown('fast');
                            $("#btn-show-tables").html('Hide Tables').removeClass('btn-primary')
                                .addClass('btn-danger');
                        });
                    } else {
                        $("#table-detail").slideUp('fast');
                        $("#btn-show-tables").html('View All Tables').removeClass('btn-danger').addClass(
                            'btn-primary');
                    }
                });

            });
        </script>
    @endpush
@endsection
