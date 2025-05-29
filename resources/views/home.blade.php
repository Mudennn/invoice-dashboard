<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <button type="button" class="btn btn-primary">Primary</button>
    <button type="button" class="btn btn-secondary">Secondary</button>
    <button type="button" class="btn btn-success">Success</button>
    <button type="button" class="btn btn-danger">Danger</button>
    <button type="button" class="btn btn-warning">Warning</button>
    <button type="button" class="btn btn-info">Info</button>
    <button type="button" class="btn btn-light">Light</button>
    <button type="button" class="btn btn-dark">Dark</button>

    <button type="button" class="btn btn-link">Link</button>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="min-height: 200px; overflow-y: auto;">
                <table class="table table-hover table-bordered align-middle text-nowrap" id="gogoTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">No</th>
                            <th scope="col" style="width: 20%;">Name</th>
                            <th scope="col" style="width: 20%;">Mgp License</th>
                            <th scope="col" style="width: 20%;">Rejection Reason</th>
                            <th scope="col" style="width: 20%;">Blocked Reason</th>
                            <th scope="col" style="width: 5%;">Block/Unblock</th>
                            <th scope="col" style="width: 5%;" class="text-center">Status</th>
                            <th scope="col" style="width: 5%;" class="text-center">Buttons</th>
                            <th scope="col" class="text-center" style="width: 5%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                
                    </tbody>
                </table>
            </div>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#gogoTable').DataTable({
                responsive: false,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                pagingType: 'full_numbers',
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
            });
        });
    </script>
</body>

</html>
