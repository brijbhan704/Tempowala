@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#main">Main</a></li>
                    <li class="active"><a data-toggle="tab" href="#gallery">Notification</a></li>
                </ul>
                <div class="tab-content">
                    <div id="main" class="tab-pane fade in">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Booking ID: <small>{{$booking->bookingID}}</small></h2>
        
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <br>
                            <form class="form-horizontal form-label-left" action="{{ url('/') }}/bookings/update/{{$booking->id}}" method="POST" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              
                              <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Username</label>
                              </div>
                              <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input class="form-control" placeholder="Username" type="text" name="username" value="{{$booking->username}}">
                              </div>
                              </div>
                              
                              <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Email</label>
                              </div>
                              <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input class="form-control" placeholder="Email" type="text" name="email" value="{{$booking->useremail}}">
                              </div>
                              </div>
        
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/bookings'">Cancel</button>
                                  <button type="reset" class="btn btn-primary">Reset</button>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
        
                            </form>
                            
                          </div>
                        </div>
                        
                    </div>
                    <div id="gallery" class="tab-pane fade in active">
                        <form>
                          <div class="x_content">   
                            
                            <div id="ajaxGetNotification">
                              
                            </div>
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Message List</label>
                            </div>
                            @if(count($message)>0)
                            <div class="form-group" style="padding-bottom:20px">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="message_list" class="form-control" id="messageList">
                                    <option value="0">--Select Message--</option>
                                    @foreach($message as $k=>$v)
                                        <option value="{{$v->id}}">{{$v->title}}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            @endif
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Notifications</label>
                            </div>
                            <div class="form-group" style="padding-bottom:80px">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <textarea class="form-control" placeholder="Notification" id="booking_msg" name="booking_msg"></textarea>
                              </div>
                            </div>
                            
                              
                              <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                   <input type="hidden" id="booking_id" name="booking_id" value="{{$booking->id}}">
                                  <button type="button" id="sendNotification" class="btn btn-success">Sent Notification</button>
                                </div>
                              </div>
                              </form>
                          </div>
                         
                         
                    </div>
                </div>

            

    
</div>
<script>
$(document).ready(function(){
    getNofication();
})
function getNofication(){
    var booking_id = jQuery('#booking_id').val();
    $.ajax({
        url:'{{ url("/") }}/bookings/getNotification',
        type: 'POST',
        data: {"booking_id":booking_id},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function(res){
            res = $.parseJSON(res);
            var str = '<table id="eventsData" class="table-responsive table table-striped table-bordered">';
            str += '<tr><th>Sr No</th><th>Notification</th><th>Sent date</th></tr>';
            $.each(res, function( index, value ) {
                
              str += '<tr>';        
                str += '<td>' + (index+1) + '</td><td>' + value.notification + '</td><td>' + value.created_at + '</td>';
              str += '</tr>';
            });                      
            str += '</table>';
            $('#ajaxGetNotification').html(str);
        }
    })
}

jQuery('#sendNotification').click(function(){
    var booking_id = jQuery('#booking_id').val();
    var booking_msg = jQuery('#booking_msg').val();
    //alert(booking_id + '     --      '+booking_msg)
    jQuery.ajax({
        type: 'POST',
        url:'{{ url("/") }}/bookings/sendNotification',
        data: {"booking_id":booking_id,"booking_msg":booking_msg},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (data) {
            getNofication();         
        },
        error: function(data){
            
        }
    })
})

$('#messageList').change(function(){
    var id = $('#messageList').val();
    if(id==0) {return false;}
    $.ajax({
        type: 'POST',
        url:'{{ url("/") }}/messages/getMessageById',
        data: {"id":id},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (data) {
            $('#booking_msg').html(data);        
        },
        error: function(data){
            
        }
    })
});
</script>

@endsection
