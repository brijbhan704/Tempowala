@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

            
            
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Name: <small>{{$vehicle->name}}</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/vehicles/update/{{$vehicle->id}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Category</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <select class="form-control" name="vehicle_type_id">
                            <option value="0">Select Type</option>
                            @if(isset($type))
                              @foreach($type as $k=>$v)
                              <option value="{{$v->id}}" @if($v->id == $vehicle->vehicle_type_id) selected @endif>{{$v->name}}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Name</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Name" type="text" name="name" value="{{$vehicle->name}}">
                        </div>
                      </div>
                      
                      <div class="form-group" style="float:left">
                      <label for="content" class="col-sm-12 control-label">Vehicle number</label>
                      </div>
                      <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                      <input class="form-control" placeholder="Vehicle Number" type="text" value="{{$vehicle->vehicle_number}}" name="vehicle_number">
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
<style>



</style>

@endsection
