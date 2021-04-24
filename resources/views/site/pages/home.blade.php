@extends('site.layouts.master')
@section('content')
    <section class="pharmacies"> 
       <div class="container">
        <div class="row">
            <div class="alert alert-danger" style="display: none">
                <p>Pharmacy Was Deleted Successfully!</p>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-default pull-right filtersbtn"><i class="fa fa-filters"></i> Filters</button>
        </div>
        <div class="row filters-container">

                <div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Filter By Name">Filter By Name</label>
                            <input type="text" class="pharm-name form-control">
                        </div>
                    </div>
    
                   <div class="col-md-4">
                        <div class="form-group">
                            <label for="Filter By Name">Filter By Address</label>
                            <input type="text" class="pharm-address form-control">
                        </div>
                   </div>

                   <div class="col-md-4">
                        <div class="form-group">
                            <label for="Filter By Name">Filter By Phone</label>
                            <input type="text" class="pharm-phone form-control">
                        </div>
                   </div>
                </div>
                
           </div>

            <div class="row">
               <div class="col-md-12">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
               </div>
                
                @if(count($pharms))
                    
                    @foreach ($pharms as $pharm)

                        <div class="col-md-12">
                            <div class="pharmacy" data-id="{{  $pharm->id }}">
                                <div class="logo pull-left">
                                    <img src="{{ url('storage/uploads/images/logos/') . '/' . $pharm->image }}" alt="" class="img-responsive img-center">
                                </div>
                                <div class="details">
                                    <p class="name">Pharmacy Name: {{ $pharm->name }}</p>
                                    <p class="address"><i class="fa fa-map-marker"></i> Pharmacy Address: {{ $pharm->address }}</p>
                                    <div class="contacts">
                                        <p class="phone"><i class="fa fa-phone"></i> Phone Number1: {{ $pharm->phone1 }} </p>
                                    </div>

                                    <span>
                                        @if($pharm->delivery == 1) 
                                            <i class="fa fa-motorcycle"></i>
                                        @else
                                            <span class="badge" style="margin-top: 5px">No Delivery</span>
                                        @endif
                                    </span>

                                    <span class="pull-right" style="margin-left: 10px">
                                        <a class="btn btn-danger" href="{{ route('delete-pharm', ['id' => $pharm->id]) }}">Delete</a>
                                    </span>

                                    <span class="pull-right">
                                        <a class="btn btn-primary" href="{{ route('update-pharm', ['id' => $pharm->id]) }}">More/Update</a>
                                    </span>

                                </div>
                            </div>
                        </div>
                    @endforeach

                @else 
                    <p class="text-center lead"> No Added Pharmacies Yet!</p>
                @endif
            </div>
       </div>
    </section>

    <script src="{{ asset('assets/js/filterpharms.js') }}" type="text/javascript"></script>
    <script>
        let deleteBtn = document.querySelectorAll('.btn-danger');
            deleteBtn.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    let pharmId = btn.parentElement.parentElement.parentElement.getAttribute('data-id');
                    console.log(pharmId);
                    e.preventDefault();
                    if(confirm("Are You Sure You Want To Delete!")) {
                        $.ajax({

                            type: "GET",
                            url: '{{route("delete-pharm")}}',
                            data: {id: pharmId},

                            success: function(response) {
                               
                                $('.alert-danger').css('display', 'block');
                                setTimeout(function() {location.reload()}, 1900);
                                
                            },
                        });
                    } else {
                        return false;
                    }
                
            });
        });
    </script>
@stop