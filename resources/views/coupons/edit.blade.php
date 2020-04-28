@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

            
            
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Name: <small>{{$coupon->name}}</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/coupons/update/{{$coupon->id}}" method="POST">
                      {{ csrf_field() }}
                      
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Title</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Title" type="text" name="title" value="{{$coupon->title}}">
                        </div>
                      </div>
                      
                      <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">code</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input class="form-control" placeholder="Coupon code" maxlength="10" type="text" value="{{$coupon->code}}" name="code">
                  </div>
                  </div> 
                  
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Discount</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input class="form-control" placeholder="Discount" maxlength="5" type="text" value="{{$coupon->discount}}" name="discount">
                  </div>
                  </div> 
                  
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Publish Date</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    
                        <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="expire_date" value="{{$coupon->publish_date}}" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      
                        </div>
                  </div> 
                  </div> 
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Expiry Date</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class='input-group date' id='datetimepicker2'>
                        <input type='text' name="expire_date" value="{{$coupon->expire_date}}" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div> 
                      </div>  
                 
                  </div>
                   
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/masterplans'">Cancel</button>
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                    
                  </div>
                </div>
            

            

    
</div>
<script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker({
                   format:'YYYY-MM-DD' 
                });
                
                $('#datetimepicker1').datetimepicker({
                   format:'YYYY-MM-DD' 
                });
            });
        </script>
@endsection
