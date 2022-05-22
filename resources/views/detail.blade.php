@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-1">
                <a href="{{ route('home') }}">Back</a>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$customer[0]->full_name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$customer[0]->email}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Birth Day</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{\Illuminate\Support\Carbon::parse($customer[0]->birth_date)->format('Y-m-d')}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Account Status</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    @if ($customer[0]->is_deleted == 0)
                                        Active
                                    @else
                                        Deleted Account
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

@endsection
