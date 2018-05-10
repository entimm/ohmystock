@extends('layouts')

@push('csses')
<style>
  .form-label-group {
      position: relative;
      margin-bottom: 1rem;
  }

  .add-form {
    max-width: 800px;
    padding: 15px;
    margin: auto;
  }
  </style>
@endpush

@section('content')
<div class="container">
  <form class="add-form" action="/store" method="post">
    <div class="text-center mb-4 mt-3">
      <h1 class="h3 mb-3 font-weight-normal">add monitors</h1>
    </div>
    
    <div class="form-label-group">
        <select class="form-control" name="start">
          <option value="{{date('Y-m-d')}}">{{date('Y-m-d')}}</option>
          <option value="{{date('Y-m-01')}}">{{date('Y-m-01')}}</option>
          <option value="{{date('Y-01-01')}}">{{date('Y-01-01')}}</option>
        </select>
    </div>

    <div class="form-label-group">
        <select class="form-control" name="group" required autofocus>
            @foreach (config('stock.groups') as $k => $value)
                <option value="{{ $k }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-label-group">
      <textarea name="codes" cols="30" rows="10" class="form-control" required></textarea>
    </div>
    {{ csrf_field() }}
    <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
  </form>
</div>
@endsection
