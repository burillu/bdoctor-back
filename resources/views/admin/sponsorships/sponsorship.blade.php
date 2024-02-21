@extends('admin.dashboard')
@section('dashboard_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Basic Plan</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus gravida enim non orci bibendum, sit amet laoreet purus gravida.</p>
                    <a href="{{route('admin.payments.show', $id=1)}}" class="btn btn-primary">Select Plan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Standard Plan</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus gravida enim non orci bibendum, sit amet laoreet purus gravida.</p>
                    <a href="{{route('admin.payments.show',$id=2)}}" class="btn btn-primary">Select Plan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Premium Plan</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus gravida enim non orci bibendum, sit amet laoreet purus gravida.</p>
                    <a href="{{route('admin.payments.show',$id=3)}}" class="btn btn-primary">Select Plan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection