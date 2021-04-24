@extends('site.layouts.master')
@section('content')
<div class="container">
    <section class="update-pharm">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
           </div>
            <div class="col-md-12">

                <form action="{{ route('update-pharm', ['id' => $pharmacy->id]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <h1 class="text-center">{{ $pharmacy->name }}</h1>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Pharmacy Name</label>
                            <input type="text" name="name" id="" class="form-control" value="{{ $pharmacy->name  }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Address</label>
                            <input type="text" name="address" id="" class="form-control" value="{{  $pharmacy->address  }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Phone Number1</label>
                            <input type="text" name="phone1" id="" class="form-control"  value="{{  $pharmacy->phone1 }}">
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Phone Number2</label>
                            <input type="text" name="phone2" id="" class="form-control" value="{{  $pharmacy->phone2 }}">
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Bio</label>
                            <textarea name="bio" id="" cols="30" rows="7" class="form-control">{{ $pharmacy->bio }}</textarea>
                        </div>    
                    </div>

                    <input type="hidden" id="lat" name="lat" id="" value="{{ $pharmacy->lat }}">
                    <input type="hidden" id="lng" name="lng" id="" value="{{ $pharmacy->lng }}">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userimage">Logo Image</label>
                            <input type="file" class="form-control image" name="image">
                        </div>
                        <div class="form-group">
                            <img src="{{ url('storage/uploads/images/logos/') . '/' .$pharmacy->image }}" class="img-thumbnail imag-preview" style="width: 100px; height:100px" alt="">                    
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="Name">Location</label>
                            <div id="googleMap" style="width:auto;height:250px;">
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Delivery</label>
                            <input type="checkbox" {{ $pharmacy->delivery == 1 ? 'checked' : '' }} name="delivery" id="" class="form-control" style="width: 20px; height: 20px"> 
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary pull-right" style="margin-top: 20px">Update <i class="fa fa-pencil"></i></button>
                </form>

            </div>
        </div>
    </section>
</div>


<!-- Map Scripts -->
<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Map Scripts -->
<script>
    $(document).on('change', '.city', function () {
        let url = '{{ url('utilities/state') }}' + '/' + $(this).val();
        $.get(url, function (data) {
            let select = $('select[name="state_id"]');
            select.empty();
            select.append('<option value="" selected></option>')
            $.each(data, function (key, value) {
                select.append('<option value=' + value.id + '>' + value.name + '</option>');
            });
        });
    });
</script>

<script>
    @if(isset($lat) && isset($lng))
    initialize({{$lat}}, {{$lng}})
    @else
    navigator.geolocation.getCurrentPosition(
        function (position) {
            initialize(position.coords.latitude, position.coords.longitude)
        },
        function errorCallback(error) {
            initialize(34.052235, -118.243683)
        }
    );
    @endif

    var geocoder;

    function initialize(lat, lng) {
        geocoder = new google.maps.Geocoder();
        var myLatLng = {
            lat,
            lng
        };

        var latLng = new google.maps.LatLng(document.querySelector('#lat').value, document.querySelector('#lng').value);

        var map = new google.maps.Map(document.getElementById('googleMap'), {
            zoom: 19,
            center: latLng
        });

        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            draggable: true
        });

        geocodePosition(latLng);

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById('lat').value = event.latLng.lat();
            document.getElementById('lng').value = event.latLng.lng();
            console.log(event.latLng.lat());
            updateMarkerStatus('Drag ended');
            geocodePosition(marker.getPosition());
        });
    }

    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function (responses) {
            console.log(responses);
            if (responses && responses.length > 0) {
                updateMarkerAddress(responses[0].formatted_address);
            } else {
                updateMarkerAddress('Cannot determine address at this location.');
            }
        });
    }

    function updateMarkerStatus(str) {
        console.log(str);
    }

    function updateMarkerAddress(str) {
        console.log(str);
    }


</script>
@stop