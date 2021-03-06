@extends('layouts.app')

@section('content')
    <div >
        <div class="col-sm-10 offset-1 mt-5 box box-primary" style="background-color: white">
            <div class="card card-info card-view">
                <div class="card-header text-white"  style="background-color: rgb(212, 206, 206) ; padding:15px">
                    <h2 class="text-center py-4 "> Package has been purchased for <br> <span style="color:#ee1e25"
                            class="fw-bold fs-1"> {{ $gymMember->name }} </span></h2>
                    
                </div>
                <div class="row">

                    <div class="col-md-4 ">
                        <img src="{{ asset('dashboard/dist/img/logo1.png') }}" style="width:400px "
                            class=" ml-5 img-fluid rounded-start w-75">
                    </div>

                    <div class="col-md-8" style="margin-top:50px">
                        <div class="card-body">

                            <div class="row">
                                <h3 class="fw-bold  my-5 p-view">Package Info </h3>

                                <div class="col-sm-4 border-right">

                                    <div class="description-block">
                                        <h5 class="description-header">Package Name</h5>
                                        <span class="description-text">{{ $triningPackage->name }}</span>
                                    </div>

                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Session Number</h5>
                                        <span class="description-text">{{ $triningPackage->sessions_number }}</span>
                                    </div>

                                </div>
                                <div class="col-sm-4  ">
                                    <div class="description-block">
                                        <h5 class="description-header">Price</h5>
                                        <span class="description-text">${{ $triningPackage->price / 100 }}</span>

                                    </div>

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
