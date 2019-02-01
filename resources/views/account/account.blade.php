@extends('layouts.app')

@section('title', 'Account Summary')

@section('content')
  
  <div class="row wrapper">
      <div class="col-sm-12">
          <ol class="breadcrumb m-t m-b">
              <li><a href="/">Dashboard</a></li>
              <li class="active">Account Summary</li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="ibox">
        <div class="ibox-title bg-primary">
          <h2>Account Summary
            <span class="pull-right">
              <a class="btn btn-w-m btn-default" href="/edit-account">Edit Account</a>
            </span>
          </h2>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="m-lg">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                    <strong>Name:</strong>
                  </div>
                  <div class="col-sm-10">
                    <p>{{ Auth::user()->name }}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <strong>Company:</strong>
                  </div>
                  <div class="col-sm-10">
                    <p>{{ Auth::user()->company_name }}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <strong>Email:</strong>
                  </div>
                  <div class="col-sm-10">
                    <p>{{ Auth::user()->email }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
