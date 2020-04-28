@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="x_panel">
      <div class="x_title">
        <h2>Booking List</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">     
          {{ csrf_field() }}     

            
          <br>     
          <table id="eventsData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th></th> 
                      <th>BookingID</th> 
                      <th>Username/Email</th> 
                      <th>Distance</th> 
                      <th>Vehicle Info</th> 
                      <th>Action</th> 
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                  <tr>
                      <th></th> 
                      <th>BookingID</th> 
                      <th>Username/Email</th> 
                      <th>Distance</th> 
                      <th>Vehicle Info</th> 
                      <th>Action</th>  
                  </tr>
              </tfoot>
          </table>                              
        </div>
</div>


<
          
<script>
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            return '<table class="table-responsive table table-striped table-bordered">'+
                '<tr>'+
                    '<th>Name:</th>'+
                    '<td>'+d.username+'</td>'+
                    '<th>Email:</th>'+
                    '<td>'+d.useremail+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<th>Phone:</th>'+
                    '<td>'+d.mobile+'</td>'+
                    '<th>Distance:</th>'+
                    '<td>'+d.distance+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<th>Price:</th>'+
                    '<td>'+d.price+'</td>'+
                    '<th>Origin:</th>'+
                    '<td>'+d.origin+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<th>Destination:</th>'+
                    '<td>'+d.destination+'</td>'+
                    '<th>Base price:</th>'+
                    '<td>'+d.base_price+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<th>Rate Per KM:</th>'+
                    '<td>'+d.rate_per_km+'</td>'+
                    '<th>GST:</th>'+
                    '<td>'+d.gst+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<th>Price With GST:</th>'+
                    '<td>'+d.price_with_gst+'</td>'+
                    '<th>Pan Card:</th>'+
                    '<td>'+d.pan_card+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<th>Coupon code:</th>'+
                    '<td>'+d.coupon_code+'</td>'+
                    '<th>Coupon Discount:</th>'+
                    '<td>'+d.coupon_discount+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<th>GST Number:</th>'+
                    '<td>'+d.gst_number+'</td>'+
                    '<td>&nbsp;</td>'+
                    '<td>&nbsp;</td>'+
                '</tr>'+
            '</table>';
        }
        var table = '';

        jQuery(document).ready(function() {
          
					//var permissonObj = '<%-JSON.stringify(permission)%>';
					//permissonObj = JSON.parse(permissonObj);


          table = jQuery('#eventsData').DataTable({
            'processing': true,
            'serverSide': true,                        
            'lengthMenu': [
              [10, 25, 50, -1], [10, 25, 50, "All"]
            ],
            dom: 'Bfrtip',
            buttons: [                        
            {extend:'csvHtml5',
              exportOptions: {
                columns: [0, 1, 2, 3,4,5,7]//"thead th:not(.noExport)"
              },
              className: 'btn btn-default',
                init: function(api, node, config) {
                  $(node).removeClass('dt-button')
                },
            },
            {extend: 'pdfHtml5',
              exportOptions: {
                columns: [0, 1, 2, 3,4,5,7] //"thead th:not(.noExport)"
              },
              className: 'btn btn-default',
                init: function(api, node, config) {
                  $(node).removeClass('dt-button')
                },
              customize : function(doc){
                    var colCount = new Array();
                    var length = $('#reports_show tbody tr:first-child td').length;
                    //console.log('length / number of td in report one record = '+length);
                    $('#reports_show').find('tbody tr:first-child td').each(function(){
                        if($(this).attr('colspan')){
                            for(var i=1;i<=$(this).attr('colspan');$i++){
                                colCount.push('*');
                            }
                        }else{ colCount.push(parseFloat(100 / length)+'%'); }
                    });
              }
            },
            {
            extend:'pageLength',
            className: 'btn btn-default',
                init: function(api, node, config) {
                  $(node).removeClass('dt-button')
                },
            
            }
            ],
            'sPaginationType': "simple_numbers",
            'searching': true,
            "bSort": false,
            "fnDrawCallback": function (oSettings) {
              jQuery('.popoverData').popover();
              // if(jQuery("#userTabButton").parent('li').hasClass('active')){
              //   jQuery("#userTabButton").trigger("click");
              // }
              // jQuery("#userListTable_wrapper").removeClass( "form-inline" );
            },
            'fnRowCallback': function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
              //if (aData["status"] == "1") {
                //jQuery('td', nRow).css('background-color', '#6fdc6f');
              //} else if (aData["status"] == "0") {
                //jQuery('td', nRow).css('background-color', '#ff7f7f');
              //}
              //jQuery('.popoverData').popover();
            },
						"initComplete": function(settings, json) {						
              //jQuery('.popoverData').popover();
					  },
            'ajax': {
              'url': '{{ url("/") }}/bookings/bookingIndexAjax',
              'headers': {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              'type': 'post',
              'data': function(d) {
                d.categoryFilter = jQuery('#mainCategory').val();
                //d.userFilter = jQuery('#userFilter option:selected').text();
                //d.search = jQuery("#userListTable_filter input").val();
              },
            },          

            'columns': [
              {
                "className":      'details-control',
                "orderable":      false,
                "data":           'null',
                "defaultContent": '<i class="fa fa-plus" aria-hidden="true"></i>'
              },      
              {
                  'data': 'bookingID',
                  'className': 'col-md-4',
                  'render': function(data,type,row){
                    var bookingID = (row.bookingID.length > 100) ? row.bookingID.substring(0,100)+'...' : row.bookingID;
                    return '<a class="popoverData" data-content="'+row.bookingID+'" rel="popover" data-placement="bottom" data-original-title="Name" data-trigger="hover">'+bookingID+'</a>';
                  }
              }, 
              {
                  'data': 'user',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    
                    return row.user.phone;
                  }
              }, 
              {
                  'data': 'distance',
                  'className': 'col-md-2'
              }, 
              {
                  'data': 'vehicle',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    
                    return row.vehicle.name;
                  }
              },
              {
                'data': 'Action',
                'className': 'col-md-2',
                'render': function(data, type, row) {
                  var buttonHtml = '<button type="button" data-id="' + row.id + '" class="btn btn-success" onclick="editpage('+row.id+')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                  return buttonHtml;
                  
                }
              }
            ]
          });   
              
          $('#eventsData tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.find("td:first").html('<i class="fa fa-plus" aria-hidden="true"></i>');
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                    tr.find("td:first").html('<i class="fa fa-minus" aria-hidden="true"></i>');
                }
            });
        });

        

        // $('#mainCategory').on('change', function(){
        //     table.draw();   
        // });

          
        function editpage(id){
          window.location.href = "{{url('/')}}/bookings/edit/"+id
        }
        

        function viewRow(id){
          alert('coming soon');
        }
        
        function ValidateEmail(email){
          if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
          }
          return false;
        }


        
      </script>
      <style>
        .dataTables_paginate a {
          background-color:#fff !important;
        }
        .dataTables_paginate .pagination>.active>a{
          color: #fff !important;
          background-color: #337ab7 !important;
        }
        .details-control{cursor:pointer;}
      </style>

@endsection
