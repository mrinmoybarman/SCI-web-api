@extends('layouts.app')

@section('content')
  
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Enquiries</h1>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card-body">
          <div class="table-responsive">
                <table id="hospital-table" class="display nowrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Hospital Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Message</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
$(function () {
    $('#hospital-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('enquiries.index') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'hospital_name' },
            { data: 'email'}, 
            { data: 'mobile'}, 
            { data: 'message'}, 
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-danger delete-btn" data-id="${row.id}">Delete</button>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        pageLength: 10,
        // dom: 'lbfrtip',
    });
});

// Handle Delete button click
$(document).on('click', '.delete-btn', function() {
        var employeeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this Enquiry ?')) {
            // Make a DELETE request to delete the employee
            $.ajax({
                url: '/enquiries/' + employeeId,
                data: {
                    _token: '{{ csrf_token() }}',  // Include CSRF token
                },
                method: 'DELETE',
                success: function(response) {
                    alert('Enquiry deleted successfully!');
                    $('#hospital-table').DataTable().ajax.reload(); // Reload the table data
                },
                error: function(xhr) {
                    alert('Error deleting Enquiry !');
                }
            });
        }
    });
</script>
@endsection