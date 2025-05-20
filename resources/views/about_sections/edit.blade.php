@extends('layouts.app')

@section('content')
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit About Section</h1>
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
            <label for="short_description">Short Description:</label>
            <textarea class="form-control @error('short_description') is-invalid @enderror" rows="4" name="short_description">{{ old('short_description', $aboutSection->short_description) }}</textarea>
            @error('short_description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="long_description">long Description:</label>
            <textarea class="form-control @error('long_description') is-invalid @enderror" rows="4" name="long_description">{{ old('long_description', $aboutSection->long_description) }}</textarea>
            @error('long_description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control @error('description') is-invalid @enderror" rows="4" name="description">{{ old('description', $aboutSection->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input @error('read_more') is-invalid @enderror" id="read_more" name="read_more" {{ old('read_more') || $aboutSection->read_more ? 'checked' : '' }}>
            <label class="form-check-label" for="read_more">Is Read More Button Active ?</label>
            @error('read_more')
                <div class="invalid-feedback d-block">
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

