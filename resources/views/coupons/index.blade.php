@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="x_panel">
      <div class="x_title">
        <h2>Coupon List</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">     
          {{ csrf_field() }}     

            
          <br>     
          <table id="eventsData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>Title</th> 
                      <th>Code</th> 
                      <th>Discount</th> 
                      <th>Published</th>
                      <th>Expiry</th>
                      <th>Action</th> 
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                  <tr>
                      <th>Title</th> 
                      <th>Code</th> 
                      <th>Discount</th>
                      <th>Published</th>
                      <th>Expiry</th>
                      <th>Action</th>  
                  </tr>
              </tfoot>
          </table>                              
        </div>
</div>


<
          
<script>
        
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
            
            },
            {
                text: 'Add Coupon',
                className: 'btn btn-primary',
                init: function(api, node, config) {
                  $(node).removeClass('dt-button')
                },
                action: function ( e, dt, node, config ) {
                  //$('#addAmenities').modal('toggle');
                  location.href="{{url('/')}}/coupons/add";
                }
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
              'url': '{{ url("/") }}/coupons/couponIndexAjax',
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
                  'data': 'title',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var title = (row.title.length > 100) ? row.title.substring(0,100)+'...' : row.title;
                    return '<a class="popoverData" data-content="'+row.title+'" rel="popover" data-placement="bottom" data-original-title="Name" data-trigger="hover">'+title+'</a>';
                  }
              }, 
              {
                  'data': 'code',
                  'className': 'col-md-2'
              }, 
              {
                  'data': 'discount',
                  'className': 'col-md-2'
              }, 
              {
                  'data': 'publish_date',
                  'className': 'col-md-2'
              }, 
              {
                  'data': 'expire_date',
                  'className': 'col-md-2'
              },
              {
                'data': 'Action',
                'className': 'col-md-2',
                'render': function(data, type, row) {
                  var buttonHtml = '<button type="button" data-id="' + row.id + '" class="btn btn-success" onclick="editpage('+row.id+')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="deleteRow('+row.id+')" id="' + row.id + '" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                  return buttonHtml;
                }
              }
            ]
          });   
              
          
        });

        

        // $('#mainCategory').on('change', function(){
        //     table.draw();   
        // });

          
        function editpage(id){
          window.location.href = "{{url('/')}}/coupons/edit/"+id
        }
        

        function deleteRow(id){
          if(confirm('Are you sure want to delete record?')){
            window.location.href = "{{url('/')}}/coupons/destroy/"+id;
          }
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
      </style>

@endsection
