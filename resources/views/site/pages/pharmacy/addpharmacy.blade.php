@extends('site.layouts.master')
@section('content')

<form id="regForm" method="POST" action="{{ route('add-pharmacy') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <h1 class="text-center">Add Pharamcy</h1>
    @include('site.partials._errors')
    <!-- One "tab" for each step in the form: -->
        <div class="tab">
            <p class="text-center lead">Basic Info</p>
            <div class="form-group">
                <label for="Name">Pharmacy Name</label>
                <input type="text" name="name" id="" class="form-control" value="{{ old('name') }}">
            </div>
            
            <div class="form-group">
                <label for="Name">Address</label>
                <input type="text" name="address" id="" class="form-control" value="{{ old('address') }}">
            </div>

            <div class="form-group">
                <label for="Name">Delivery</label>
                <input type="checkbox" name="delivery" id="" class="form-control" style="width: 20px; height: 20px"> 
            </div>

            <div class="form-group">
                <label for="Name">Location</label>
                <div id="googleMap" style="width:auto;height:250px;"></div> 
            </div>
        </div>

        <input type="hidden" id="lat" name="lat" id="">
        <input type="hidden" id="lng" name="lng" id="">
        
        <div class="tab">
            <p class="lead text-center">Logos And Images</p>
            <div class="form-group">
                <label for="userimage">Logo Image</label>
                <input type="file" class="form-control image" name="image" value="{{ old('image') }}">
            </div>
            <div class="form-group">
                <img src="{{ url('storage/uploads/images/logos/default.png') }}" class="img-thumbnail imag-preview" style="width: 100px; height:100px" alt="">                    
            </div>
       
            <div class="form-group">
                <label for="userimage">Other Images <small>you can select multiple images by pressing ctrl</small></label>
                <input type="file" id="files" name="images[]" multiple class="form-control"><br><br>
            </div>

        </div>

        <div class="tab">
            <p class="lead text-center">Contact Information</p>
            <div class="form-group">
                <label for="Name">Phone Number1</label>
                <input type="text" name="phone1" id="" class="form-control"  value="{{ old('phone1') }}">
            </div>

            <div class="form-group">
                <label for="Name">Phone Number2</label>
                <input type="text" name="phone2" id="" class="form-control" value="{{ old('phone2') }}">
            </div>

            <div class="form-group">
                <label for="Name">Bio</label>
                <input type="text" name="bio" id="" class="form-control" value="{{ old('bio') }}">
            </div>
        </div>
        
        <div style="overflow:auto;">
        <div style="float:right;">
            <button class="btn btn-primary" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button class="btn btn-primary" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
        </div>
    
        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;margin-top:40px;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
        </div>
        
    </form>

    <!-- Multi Step Form Script -->
    <script src="{{ asset('assets/js/multiform.js') }}"></script>
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

            var latLng = new google.maps.LatLng(34.052235, -118.243683);

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