@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

            
            
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Name: <small>{{$message->name}}</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/messages/update/{{$message->id}}" method="POST">
                      {{ csrf_field() }}
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Type</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <select class="form-control" name="type">
                            <option value="0">Select Type</option>
                            <option value="notification" @if($message->type=="notification") selected @endIf>Notification</option>
                            <option value="promotion" @if($message->type=="promotion") selected @endIf>Promotion</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Title</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Title" type="text" name="title" value="{{$message->title}}">
                        </div>
                      </div>
                      
                      <div class="form-group" style="float:left">
                      <label for="content" class="col-sm-12 control-label">Message</label>
                      </div>
                      <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                      <textarea class="form-control" type="text" name="description">{{$message->description}}</textarea>
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
