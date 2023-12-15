<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Hello, world!</title>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col" colspan="2" class="text-center">Action</th>
                <th>secrit key</th>

            </tr>
        </thead>
        @foreach ($cusomer_detail as $detail)
            <tr>
                <td>{{ $detail->id }}</td>
                <td>{{ $detail->name }}</td>
                <td>{{ $detail->email }}</td>
                <td>{{ $detail->password }}</td>
                <td>

                    <form action="{{ url('/api/customer/' . $detail->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    <a class="btn btn-success" href="{{ url('/api/customer/' . $detail->id . '/edit') }}">Update</a>
                </td>
                <td>
                    <button class="btn  btn-dark  revealButtom" data-get="{{ $detail->id }}"> <i
                            class="fa-regular fa-eye-slash " style="    margin-right: 20px;"></i>Reveal test
                        Key</button>
                </td>
            </tr>
        @endforeach
        <tbody>
        </tbody>
    </table>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Reveal Secrit Key</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">Udpate Secrit Key </label>
                            <input type="text" name="access_token" id="myInput" class="form-control">
                        </div>
                        <div class="col-md-4 mt-4">
                            <button onclick="myFunction()" class="btn bg-primary text-white">Copy Code</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_token">Update key</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".revealButtom", function() {
                var id = $(this).data("get");
                $.ajax({
                    url: "/api/customer/" + id,
                    method: "GET",
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $("#exampleModal").modal("show");
                            $("#myInput").val(res.data.access_token)
                        } else {
                            alert("300");
                        }
                    }
                })
            })
            $(document).on("click", "#myInput", function() {
                var token_id = $(".revealButtom").data("get");
                $.ajax({
                    url: "/api/updateToken/" + token_id, // Corrected URL
                    method: "PUT",
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.data == 200) {
                            $("#exampleModal").modal("hide");
                            alert("200");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            alert("Copied the text: " + copyText.value);
        }
    </script>
</body>

</html>
