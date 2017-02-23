@extends('layouts.main')
@section('title')
@lang('home.titles.contact')
@endsection
@section('content')
<!-- Contact Us -->
<div class="row">
      <div class="col-md-12">
        <div class="well well-sm">
          <form class="form-horizontal" action="" method="post">
          <fieldset>
            <legend class="text-center">@lang('home.titles.contact')</legend>
    
            <!-- Name input-->
            <div class="form-group">
                
              <label class="col-md-2 control-label" for="name"><i class="fa fa-user-circle-o fa-2x"></i></label>
              <div class="col-md-6">
                <input id="name" name="name" type="text" placeholder="@lang('home.contact.name')" class="form-control">
              </div>
            </div>
    
            <!-- Email input-->
            <div class="form-group">
                <label class="col-md-2 control-label" for="email"><i class="fa fa-envelope-o fa-2x"></i></label>
              <div class="col-md-6">
                <input id="email" name="email" type="text" placeholder="@lang('home.contact.email')" class="form-control">
              </div>
            </div>
    
            <!-- Message body -->
            <div class="form-group">
              <label class="col-md-2 control-label" for="message"><i class="fa fa-newspaper-o fa-2x"></i></label>
              <div class="col-md-9">
                <textarea class="form-control" id="message" name="message" placeholder="@lang('home.contact.message')" rows="5"></textarea>
              </div>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-11 text-right">
                <button type="submit" class="btn btn-primary btn-lg">@lang('home.contact.submit')</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
	</div>
@endsection
