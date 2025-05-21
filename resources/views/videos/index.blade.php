@extends('layouts.app')


@section('content')

<style>

  #progressOverlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.85);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
}

.upload-overlay .upload-content {
  color: #fff;
  max-width: 600px;
  text-align: center;
}

</style>


<!-- Fullscreen Upload Overlay -->
<div id="progressOverlay" style="display: none;">
  <div class="upload-overlay">
    <div class="upload-content text-center">
      <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
        <span class="sr-only">Loading...</span>
      </div>
      <p class="text-light mt-3">Uploading video, please do not close the screen...</p>
      <div class="progress w-75 mx-auto mt-3">
        <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%;">0%</div>
      </div>
    </div>
  </div>
</div>


<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Add New Videos</h1>
    </div>

    <div class="row">

      <div class="col-md-8 form-box">
        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="hospital">Select Hospital</label>
            <select class="form-control @error('hospitalId') is-invalid @enderror" aria-describedby="Select hospital" name="hospitalId" {{ $userHospitalId !== null ? 'readonly' : '' }} required>
              <option value="">Select Hospital</option>
              @foreach ($hospitals as $hospital)
                  <option value="{{ $hospital->id }}" @if (old('hospitalId', $userHospitalId) == $hospital->id) selected @endif>
                    {{ $hospital->name }}
                  </option>
              @endforeach
            </select>
            @error('hospitalId')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="name">title:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="link">External Link :</label>
            <input type="text" class="form-control @error('link') is-invalid @enderror" 
                  value="{{ old('link') }}" name="link" id="linkInput">
            @error('link')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="video">Video :</label>
            <input type="file" id="videoInput" name="video" accept="video/*" 
                  class="@error('video') is-invalid @enderror" onchange="handleVideoSelection(this)">
            
            <video id="video-preview" width="320" height="240" controls style="display: none; margin-top: 10px;">
              <source src="#" type="video/mp4">
              Your browser does not support the video tag.
            </video>

            @error('video')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>


          {{-- <div class="form-group">
            <label for="link">External Link :</label>
            <input type="text" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" name="link">
            @error('link')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div> --}}

          <div class="form-group">
            <label for="title">Index:</label>
            <input type="text" class="form-control @error('indexx') is-invalid @enderror" value="{{ old('indexx') }}" name="indexx">
            @error('indexx')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="photo">Thumbnail :</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="@error('photo') is-invalid @enderror" onchange="previewImage(this, '#Photo-preview')">
            <img id="Photo-preview" src="#" height="50" style="display:none;">
            @error('photo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

         {{-- <div class="form-group">
          <label for="video">Video :</label>
          <input type="file" id="video" name="video" accept="video/*" class="@error('video') is-invalid @enderror" onchange="previewVideo(this, '#video-preview')">
          
          <video id="video-preview" width="320" height="240" controls style="display: none; margin-top: 10px;">
            <source src="#" type="video/mp4">
            Your browser does not support the video tag.
          </video>

          @error('video')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div> --}}

          
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>

    </div>
    
  </div>
  <hr />

  
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Videos</h1>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card-body">
          <div class="table-responsive">
                <table id="hospital-table" class="display nowrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Hospital Name</th>
                          <th>Added By</th>
                          <th>Thumbnail</th>
                          <th>Video</th>
                          <th>indexx</th>
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
        ajax: "{{ route('videos.index') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'hospital_name' },
            { data: 'added_by_name' },
            {
                data: null,
                render: function(data, type, row) {
                    return `<img src="/storage/${row['photo']}" style="max-height:70px;width:auto" />`;
                },
                orderable: false,
                searchable: false
            },
            

            {
              data: null,
              render: function(data, type, row) {
                if (row.video) {
                  return `
                    <video width="160" height="90" controls>
                      <source src="/storage/${row.video}" type="video/mp4">
                      Your browser does not support the video tag.
                    </video>`;
                } else {
                  return 'No Video';
                }
              }
            },

            { data: 'indexx'}, 
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary edit-btn" data-id="${row.id}">Edit</button>
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


// Handle Edit button click
$(document).on('click', '.edit-btn', function() {
  var employeeId = $(this).data('id');
  window.location.href = '/videos/' + employeeId + '/edit'; // Redirect to edit page
});

// Handle Delete button click
$(document).on('click', '.delete-btn', function() {
        var employeeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this Video ?')) {
            // Make a DELETE request to delete the employee
            $.ajax({
                url: '/videos/' + employeeId,
                data: {
                    _token: '{{ csrf_token() }}',  // Include CSRF token
                },
                method: 'DELETE',
                success: function(response) {
                    alert('Video deleted successfully!');
                    $('#hospital-table').DataTable().ajax.reload(); // Reload the table data
                },
                error: function(xhr) {
                    alert('Error deleting Video !');
                }
            });
        }
    });


</script>

<script>
  function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.querySelector(previewId);
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    } else {
      preview.src = '#';
      preview.style.display = 'none';
    }
  }
</script>

<script>
  const linkInput = document.getElementById('linkInput');
  const videoInput = document.getElementById('videoInput');

  // When user types a link, disable video input
  linkInput.addEventListener('input', function () {
    if (this.value.trim() !== '') {
      videoInput.disabled = true;
      clearVideoSelection();
    } else {
      videoInput.disabled = false;
    }
  });

  function handleVideoSelection(input) {
    const file = input.files[0];

    if (linkInput.value.trim() !== '') {
      alert('You cannot upload a video and enter a link at the same time. Please clear the link.');
      input.value = ''; // Clear the video input
      return;
    }

    if (file && file.type.startsWith('video/')) {
      previewVideo(input, '#video-preview');
      linkInput.disabled = true;
    } else {
      document.querySelector('#video-preview').style.display = 'none';
      linkInput.disabled = false;
    }
  }

  function previewVideo(input, previewSelector) {
    const preview = document.querySelector(previewSelector);
    const file = input.files[0];

    if (file && file.type.startsWith('video/')) {
      const reader = new FileReader();

      reader.onload = function (e) {
        preview.style.display = 'block';
        preview.querySelector('source').src = e.target.result;
        preview.load();
      }

      reader.readAsDataURL(file);
    } else {
      preview.style.display = 'none';
    }
  }

  function clearVideoSelection() {
    videoInput.value = '';
    document.getElementById('video-preview').style.display = 'none';
    linkInput.disabled = false;
  }
</script>

<script>
$('form').on('submit', function (e) {
  e.preventDefault();
  var formData = new FormData(this);

  $.ajax({
    xhr: function () {
      var xhr = new XMLHttpRequest();
      xhr.upload.addEventListener('progress', function (e) {
        if (e.lengthComputable) {
          var percent = Math.round((e.loaded / e.total) * 100);
          $('#progressBar').css('width', percent + '%').text(percent + '%');
        }
      }, false);
      return xhr;
    },
    url: $(this).attr('action'),
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $('#progressOverlay').show();
    },
    success: function (response) {
      alert('Upload completed!');
      location.reload(); // or redirect
    },
    error: function () {
      alert('Upload failed!');
      $('#progressOverlay').hide();
    }
  });
});

</script>

@endsection