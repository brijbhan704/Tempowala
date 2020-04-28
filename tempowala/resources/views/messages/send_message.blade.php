@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<link href="{{ asset('/css/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

      <div class="x_panel">
        <div class="x_title">
          <h2>Send Promotional Message</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
                <form class="form-horizontal form-label-left" action="{{ url('/') }}/send_message" method="POST">
                  {{ csrf_field() }}

                  
                  @if(count($messageList)>0)
                    <div class="form-group" style="padding-bottom:20px">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <select name="title" class="form-control" id="messageList">
                            <option value="0">--Select Message--</option>
                            @foreach($messageList as $k=>$v)
                                <option value="{{$v->id}}">{{$v->title}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  @endif    
                             
                   
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Description</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea class="form-control" type="text" id="booking_msg" name="description"></textarea>
                  </div>
                  </div>  
                  
                  @if(count($userList)>0)
                    <div class="form-group" style="padding-bottom:20px">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <select name="userlist[]" class="form-control" multiple="multiple" id="messageList">
                            @foreach($userList as $k=>$v)
                                <option value="{{$v->id}}">{{$v->name.' '.$v->email.' '.$v->phone}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  @endif
                  
                  <div class="ln_solid"></div>
                  <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12 ">
                  <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/messages'">Cancel</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>
            
                  
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
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
});
</script>

@endsection
