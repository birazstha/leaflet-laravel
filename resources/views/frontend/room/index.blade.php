@extends('layouts.master')

@section('content')
    <div class="card m-4">
        <div class="card-header d-flex justify-content-between">
            <span>Room</span>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Create</a>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Address</th>
                        <th scope="col">Coordinates</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $room->title }}</td>
                            <td>{{ $room->address }}</td>
                            <td>{{ $room->latitude . ',' . $room->longitude }}</td>
                            <td>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="post">
                                    <button class="btn btn-danger btn-sm" type="submit"><i
                                            class="fas fa-trash"></i></button>
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

    <div class="card m-4">
        <div class="card-header">
            Map
        </div>
        <div id="lists" style="height: 50rem"></div>
    </div>
@endsection

@section('script')
    <script>
        //Map Initialization
        var lists = L.map("lists").setView([27.685178441044187, 85.32034981801917], 16);
        var currentMarker = null;
        var testMarker = null;

        // //OSM layer
        // var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        // });
        // osm.addTo(lists);


        var googleStreets = L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        });

        googleStreets.addTo(lists);

        L.marker([27.685178441044187, 85.32034981801917]).addTo(lists);


        // Marker
        var myIcon = L.icon({
            iconUrl: "red_marker.png",
            iconSize: [40, 40],
        });

        map.on("click", function(e) {
            let lat = e.latlng.lat;
            let long = e.latlng.lng;
            $("#lat").val(lat);
            $("#long").val(long);
            $("#latlong").val(lat + "," + long);

            map.removeLayer(testMarker);
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }

            currentMarker = L.marker(e.latlng);

            currentMarker.addTo(map);
        });
    </script>
@endsection
