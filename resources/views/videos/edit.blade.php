@extends('layouts.app')

@section('content')

<style>
  #progressOverlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
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
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Video</h1>
  </div>

  <div class="row">
    <div class="col-md-8 form-box">
      <form action="{{ route('videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Use PUT method for update --}}

        <div class="form-group">
          <label for="hospital">Select Hospital</label>
          <select class="form-control @error('hospitalId') is-invalid @enderror" aria-describedby="Select hospital" name="hospitalId" {{ $userHospitalId !== null ? 'readonly' : '' }} required>
            <option value="">Select Hospital</option>
            @foreach ($hospitals as $hospital)
              <option value="{{ $hospital->id }}" 
                @if (old('hospitalId', $video->hospitalId ?? $userHospitalId) == $hospital->id) selected @endif>
                {{ $hospital->name }}
              </option>
            @endforeach
          </select>
          @error('hospitalId')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="name">Title:</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $video->name) }}" name="name" required>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="link">External Link :</label>
          <input type="text" class="form-control @error('link') is-invalid @enderror" 
            value="{{ old('link', $video->link) }}" name="link" id="linkInput">
          @error('link')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="video">Video :</label>
          <input type="file" id="videoInput" name="video" accept="video/*" 
            class="@error('video') is-invalid @enderror" onchange="handleVideoSelection(this)">
          
          {{-- Show existing video if available --}}
          @if($video->video)
            <video id="video-preview" width="320" height="240" controls style="margin-top: 10px;">
              <source src="/storage/{{ $video->video }}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          @else
            <video id="video-preview" width="320" height="240" controls style="display: none; margin-top: 10px;">
              <source src="#" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          @endif

          @error('video')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="indexx">Index:</label>
          <input type="text" class="form-control @error('indexx') is-invalid @enderror" value="{{ old('indexx', $video->indexx) }}" name="indexx">
          @error('indexx')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="photo">Thumbnail :</label>
          <input type="file" id="photo" name="photo" accept="image/*" class="@error('photo') is-invalid @enderror" onchange="previewImage(this, '#Photo-preview')">
          @if($video->photo)
            <img id="Photo-preview" src="/storage/{{ $video->photo }}" height="50" style="display:block; margin-top: 10px;">
          @else
            <img id="Photo-preview" src="#" height="50" style="display:none;">
          @endif
          @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
<hr />

@endsection


@section('scripts')

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
        if (response.redirect) {
            window.location.href = response.redirect;
        } else {
            location.reload(); // fallback
        }
    }
    error: function () {
      alert('Upload failed!');
      $('#progressOverlay').hide();
    }
  });
});

</script>

@endsection