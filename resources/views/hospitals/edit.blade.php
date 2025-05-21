@extends('layouts.app')

@section('content')
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Hospital</h1>
  </div>

  <div class="row">
    <div class="col-md-8 form-box">
      <form action="{{ route('hospitals.update', $hospital->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- This is important for PUT method --}}
        
        <div class="form-group">
          <label for="name">Edit Hospital Name :</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" 
                 name="name" value="{{ old('name', $hospital->name) }}">
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="aname">Edit Hospital Name in Assamese:</label>
          <input type="text" class="form-control" name="aname" value="{{ old('aname', $hospital->aname) }}">
        </div>

        <div class="form-group">
          <label for="location">Edit Hospital Location:</label>
          <input type="text" class="form-control @error('location') is-invalid @enderror" 
                 name="location" value="{{ old('location', $hospital->location) }}">
          @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="phone">Edit Hospital Talephone Number :</label>
          <input type="text" class="form-control" name="phone" value="{{ old('phone', $hospital->phone) }}">
        </div>

        <div class="form-group">
          <label for="phone">Edit Hospital Mobile Number :</label>
          <input type="text" class="form-control" name="phone2" value="{{ old('phone2', $hospital->phone2) }}">
        </div>

        <div class="form-group">
          <label for="email">Edit Hospital Email :</label>
          <input type="email" class="form-control" name="email" value="{{ old('email', $hospital->email) }}">
        </div>

        <div class="form-group">
          <label for="whatsapp">Edit Hospital Whatsapp No:</label>
          <input type="text" class="form-control" name="whatsapp" value="{{ old('whatsapp', $hospital->whatsapp) }}">
        </div>

        <div class="form-group">
          <label for="address">Edit Hospital Address:</label>
          <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="4">{{ old('address', $hospital->address) }}</textarea>
          @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="gmap">Edit Hospital Google map link:</label>
          <input class="form-control" type="text" name="gmap" value="{{ old('gmap', $hospital->gmap) }}">
        </div>

        <div class="form-group">
          <label for="level">Update Level</label>
          <select class="form-control @error('level') is-invalid @enderror" name="level">
            <option value="">Select Level</option>
            <option value="L1" {{ old('level', $hospital->level) == 'L1' ? 'selected' : '' }}>L1</option>
            <option value="L2" {{ old('level', $hospital->level) == 'L2' ? 'selected' : '' }}>L2</option>
            <option value="L3" {{ old('level', $hospital->level) == 'L3' ? 'selected' : '' }}>L3</option>
          </select>
          @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="facebook">Edit Facebook link:</label>
          <input type="text" class="form-control" name="facebook" value="{{ old('facebook', $hospital->facebook) }}">
        </div>

        <div class="form-group">
          <label for="instagram">Edit Instagram link:</label>
          <input type="text" class="form-control" name="instagram" value="{{ old('instagram', $hospital->instagram) }}">
        </div>

        <div class="form-group">
          <label for="twitter">Edit Twitter link:</label>
          <input type="text" class="form-control" name="twitter" value="{{ old('twitter', $hospital->twitter) }}">
        </div>

        <div class="form-group">
          <label for="linkedin">Edit LinkedIn link:</label>
          <input type="text" class="form-control" name="linkedin" value="{{ old('linkedin', $hospital->linkedin) }}">
        </div>

        <div class="form-group">
          <label for="intro_heading">Edit Intro Heading :</label>
          <input type="text" class="form-control @error('intro_heading') is-invalid @enderror" 
                 name="intro_heading" value="{{ old('intro_heading', $hospital->intro_heading) }}">
          @error('intro_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="address">Edit Intro :</label>
          <textarea class="form-control @error('intro') is-invalid @enderror" name="intro" rows="4">{{ old('intro', $hospital->intro) }}</textarea>
          @error('intro')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="logo_primary">Update Primary Logo (Square):</label>
          <input type="file" id="logo_primary" name="logo_primary" accept="image/*" class="@error('logo_primary') is-invalid @enderror" onchange="previewImage(this, '#logo_primary-preview')">
          
          @if($hospital->logo_primary)
            <p class="mt-2">Current:</p>
            <img id="logo_primary-preview" src="{{ asset('storage/' . $hospital->logo_primary) }}" height="50" style="display: block;">
          @else
            <img id="logo_primary-preview" src="#" height="50" style="display:none;">
          @endif
          
          @error('logo_primary')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="logo_secondary">Update Secondary Logo (Square):</label>
          <input type="file" id="logo_secondary" name="logo_secondary" accept="image/*" class="@error('logo_secondary') is-invalid @enderror" onchange="previewImage(this, '#logo_secondary-preview')">
          
          @if($hospital->logo_secondary)
            <p class="mt-2">Current:</p>
            <img id="logo_secondary-preview" src="{{ asset('storage/' . $hospital->logo_secondary) }}" height="50" style="display: block;">
          @else
            <img id="logo_secondary-preview" src="#" height="50" style="display:none;">
          @endif
          
          @error('logo_secondary')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>


        <div class="form-group">
          <label for="about_bg">Update About Background :</label>
          <input type="file" id="about_bg" name="about_bg" accept="image/*" class="@error('about_bg') is-invalid @enderror" onchange="previewImage(this, '#about_bg-preview')">
          
          @if($hospital->about_bg)
            <p class="mt-2">Current:</p>
            <img id="about_bg-preview" src="{{ asset('storage/' . $hospital->about_bg) }}" height="50" style="display: block;">
          @else
            <img id="about_bg-preview" src="#" height="50" style="display:none;">
          @endif
          
          @error('about_bg')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>


        <button type="submit" class="btn btn-primary">Update Hospital</button>
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

