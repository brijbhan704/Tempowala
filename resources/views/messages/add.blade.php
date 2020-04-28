@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<link href="{{ asset('/css/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

      <div class="x_panel">
        <div class="x_title">
          <h2>Add Message</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
                <form class="form-horizontal form-label-left" action="{{ url('/') }}/messages/add" method="POST">
                  {{ csrf_field() }}

                  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Type</label>
                  </div>
                  <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <select class="form-control" name="type">
                        <option value="0">Select Type</option>
                        <option value="notification">Notification</option>
                        <option value="promotion">Promotion</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Title</label>
                  </div>
                  <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input class="form-control" placeholder="Title" type="text" name="title">
                    </div>
                  </div>
                             
                   
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Description</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea class="form-control" type="text" name="description"></textarea>
                  </div>
                  </div>  
                  

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
@endsection
