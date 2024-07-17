<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets\css\style.css">
    <link href="assets\css\style1.css" rel="stylesheet">
    <link href="assets\css\style3.css" rel="stylesheet">
    <script src="assets\js\file1.js"></script>
    <script src="assets\js\file4.js"></script>
    <script src="assets\js\file2.js"></script>
    <script src="assets\js\file3.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<h1 id="main_title">Application</h1>
    <div class="container">

        <div class="box1">
            <h2>Cars Info</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">ADD</button>
            <table id="cars" class="table table-hover table-bordered table-striped" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>quantity</th>
                        <th>price</th>
                        <th>Actions</th>
                    </tr>
                  
                </thead>
                @foreach ($cars as $car)
                <tr data-id="{{ $car->id }}">
                    <td>{{ $car->id }}</td>
                    <td>{{ $car->make }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->quantity }}</td>
                    <td>{{ $car->price }}</td>
                    <td>
                    <button class="btn btn-danger delete" data-id="{{ $car->id }}" style="margin-left:10px;">Delete</button>

                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" 
                            onclick="setUpdateForm({{ $car->id }}, '{{ $car->make }}', '{{ $car->model }}', '{{ $car->quantity }}', {{ $car->price }})">Update</button>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>

<form id="addForm" method="post" action="{{ route('cars.store') }}">
    @csrf
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Add Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="addMake">Make</label>
            <input type="text" name="make" id="addMake" class="form-control">
        </div>
        <div class="form-group">
            <label for="addModel">Model</label>
            <input type="text" name="model" id="addModel" class="form-control">
        </div>
        <div class="form-group">
            <label for="addquantity">quantity</label>
            <input type="text" name="quantity" id="addquantity" class="form-control">
        </div>
        <div class="form-group">
            <label for="addprice">Price</label>
            <input type="text" name="price" id="addprice" class="form-control">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" value="ADD">
    </div>
</div>
</div>
</div>
</form>

 <!-- Update Modal -->
 <form id="updateForm" method="post" action="{{ route('cars.update') }}">
        @csrf
        @method('PUT')
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateModalLabel">Update Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="updateId">
                        <div class="form-group">
                            <label for="updateMake">Make</label>
                            <input type="text" name="make" id="updateMake" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="updateModel">Model</label>
                            <input type="text" name="model" id="updateModel" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="updatequantity">Quantity</label>
                            <input type="text" name="quantity" id="updatequantity" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="updateprice">Price</label>
                            <input type="text" name="price" id="updateprice" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
<script>
        $(document).ready(function() {

            function validateNumberInput(value) {
            return /^[0-9]+$/.test(value);
        }

        function showValidationError(message) {
            alert(message);
        }            // Add operation
            $('#addForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var quantity = $('#addquantity').val();
            var price = $('#addprice').val();
            if (!validateNumberInput(quantity)) {
                showValidationError('Quantity must be a valid number.');
                return;
            }
            if (!validateNumberInput(price)) {
                showValidationError('Price must be a valid number.');
                return;
            }
                $.ajax({
                    type: 'POST',
                    url: '{{ route('cars.store') }}', // Replace with the URL for adding data
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addModal').modal('hide');
                        alert('Data added successfully!');
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                        alert('Error adding data!');
                    }
                });
            });

            // Update operation
            $('#updateForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var quantity = $('#updatequantity').val();
            var price = $('#updateprice').val();
            if (!validateNumberInput(quantity)) {
                showValidationError('Quantity must be a valid number.');
                return;
            }
            if (!validateNumberInput(price)) {
                showValidationError('Price must be a valid number.');
                return;
            }
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#updateModal').modal('hide');
                        alert('Data updated successfully!');
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                        alert('Error updating data!');
                    }
                });
            });

             // Delete operation
             $(document).on('click', '.delete', function() {
                var id = $(this).data('id'); // Get the ID from data attribute
                if (confirm("Are you sure you want to delete this data?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ url('cars') }}/' + id,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert('Data deleted successfully!');
                            $('tr[data-id="' + id + '"]').remove(); // Remove the row from the table
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status + ' - ' + error);
                            alert('Error deleting data!');
                        }
                    });
                }
            });

            // Set update form values
            window.setUpdateForm = function(id, make, model, quantity, price) {
                $('#updateId').val(id);
                $('#updateMake').val(make);
                $('#updateModel').val(model);
                $('#updatequantity').val(quantity);
                $('#updateprice').val(price);
                $('#updateForm').attr('action', '{{ url('cars') }}/' + id);
            }
        });
</script>

</body>
</html>