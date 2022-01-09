<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.min.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    <div class="container">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Weather Listing</h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="date" name="created_at" placeholder="Select Date" class="form-control" id="created_at">
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <table class="table table-bordered" id="weather-datatable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">City Name</th>
                            <th scope="col">Country Code</th>
                            <th scope="col">Latitude</th>
                            <th scope="col">Longitude</th>
                            <th scope="col">Temperature</th>
                            <th scope="col">Created Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <div class="pull-right"></div>
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var t = $('#weather-datatable').DataTable({
                "pageLength": 50,
                processing: true,
                serverSide: true,
                "dom": 'lBfrtip',
                "ordering": false,
                buttons: [{
                extend: 'csvHtml5',
                className: 'btn btn-primary info-btn',
                footer: true,
                exportOptions: {
                modifier : {
                            order : 'index', // 'current', 'applied','index', 'original'
                            page : 'all', // 'all', 'current'
                            search : 'none' // 'none', 'applied', 'removed'
                        },
                        columns: [1,2,3,4,5,6]
                    }
                },
                ],
                ajax: {
                    url: "{{ route('weather.ajax.list') }}",
                    type: 'GET',
                    data: function (d) {
                        d.created_at = $('#created_at').val();
                    }
                },
                columns: [
                {data: 'id', name: 'id'},
                {data: 'city', name: 'city'},
                {data: 'country', name: 'country'},
                {data: 'lat', name: 'lat'},
                {data: 'long', name: 'long'},
                {data: 'temp', name: 'temp'},
                {data: 'created_at', name: 'created_at'}
                ],
                "deferRender": true,
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                },
                {
                    "targets": 0,
                    "visible": false,
                },
                {
                    "targets": 6,
                    "data": "created_at",
                    "render": function (data, type, full, meta) {
                        return moment(data).format('LLLL');
                    }
                },
                ],
            });

            $('#created_at').on('change', function () {
                $('#weather-datatable').DataTable().draw(true);
            });

            t.on('order.dt search.dt', function () {
                t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

    </script>

    <script type="text/javascript">
        var url = '{{ route('get-weather-data') }}'
        setInterval(function(){
            fetch(url).then(res => 'Success');
        }, 30000);
    </script>
</body>
</html>
