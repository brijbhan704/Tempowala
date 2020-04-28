@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<link href="{{ asset('/css/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

      <div class="x_panel">
        <div class="x_title">
          <h2>Add Vehicle Type</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
                <form class="form-horizontal form-label-left" action="{{ url('/') }}/vehicletypes/add" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}

                  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Vehicle Type</label>
                  </div>
                  <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input class="form-control" placeholder="Vehicle Type" type="text" name="name">
                    </div>
                  </div>
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Image Icon</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="file" class="form-control" name="file">
                        </div>
                      </div> 
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Capacity</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input class="form-control" placeholder="Capacity" type="text" name="capacity">
                  </div>
                  </div> 
                  
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Base Price</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input class="form-control" placeholder="Base Price" type="text" name="base_price">
                  </div>
                  </div> 
                  
                  <div class="form-group">
                  <label for="content" class="col-sm-12" style="float:left">Rate Per KM</label>
                  </div>
                  <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <input class="form-control" placeholder="Rate Per KM" type="text" name="rate_per_km">
                  </div>
                  </div>
                  
                  
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Rate Per 2 to 5 KM</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input class="form-control" placeholder="Rate Per 2 to 5 KM" type="text" name="rate_2_to_5_km">
                  </div>
                  </div>
                  
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Base fare > 6KM</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input class="form-control" placeholder="Base fare > 6KM" type="text" name="rate_gt_6_km">
                  </div>
                  </div>    
                  
                  <div class="ln_solid"></div>
                  <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12 ">
                  <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/vehiclestypes'">Cancel</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>

          
        </div>
    </div>
</div>
@endsection
