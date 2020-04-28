@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

            
            
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Settings: </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/users/settings/1" method="POST">
                      {{ csrf_field() }}
                      
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Admin Email</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Admin Email" type="text" name="admin_email" value="{{$settings->admin_email}}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">GST %</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="GST" type="text" name="GST" value="{{$settings->GST}}">
                        </div>
                      </div>
                      
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Terms and Condition</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <textarea class="form-control" rows="8" name="terms_and_condition">{{$settings->terms_and_condition}}</textarea>
                        </div>
                      </div>


                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Privacy Policy</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <textarea class="form-control" rows="8" name="privacy_policy">{{$settings->privacy_policy}}</textarea>
                        </div>
                      </div>

                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Facebook Link</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Facebook link" type="text" name="fb_link" value="{{$settings->fb_link}}">
                        </div>
                      </div>

                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Twitter Link</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Twitter" type="text" name="twitter_link" value="{{$settings->twitter_link}}">
                        </div>
                      </div>

                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Instagram Link</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control" placeholder="Instagram" type="text" name="insta_link" value="{{$settings->insta_link}}">
                        </div>
                      </div>

                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/users/settings/1'">Cancel</button>
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
