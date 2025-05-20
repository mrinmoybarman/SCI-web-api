@extends('layouts.app')

@section('content')
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Partner</h1>
  </div>

  <div class="row">
    <div class="col-md-8 form-box">
      <form action="{{ route('about_sections.update', $aboutSection->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="hospital">Select Hospital</label>
            <select class="form-control @error('hospitalId') is-invalid @enderror" name="hospitalId" {{ $userHospitalId !== null ? 'readonly' : '' }} required>
                <option value="">Select Hospital</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}" @if (old('hospitalId', $aboutSection->hospitalId ?? $userHospitalId) == $hospital->id) selected @endif>
                        {{ $hospital->name }}
                    </option>
                @endforeach
            </select>
            @error('hospitalId')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Name : </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $aboutSection->name) }}" name="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control @error('details') is-invalid @enderror" rows="4" name="details">{{ old('details', $aboutSection->details) }}</textarea>
            @error('details')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Edit Index:</label>
            <input type="text" class="form-control @error('indexx') is-invalid @enderror" value="{{ old('indexx', $aboutSection->indexx) }}" name="indexx">
            @error('indexx')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Slide Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="@error('photo') is-invalid @enderror" onchange="previewImage(this, '#Photo-preview')">
            <img id="Photo-preview" src="{{ $aboutSection->photo ? asset('storage/'.$aboutSection->photo) : '#' }}" height="50" style="{{ $aboutSection->photo ? '' : 'display:none;' }}">
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    
    </div>
  </div>

</div>
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
@endsection

