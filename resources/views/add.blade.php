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
        <input type="text" class="form-control" name="start" value="{{date('Y-m-d')}}">
    </div>

    <div class="form-label-group">
        <select class="form-control" name="group" required autofocus>
            @foreach (config('stock.groups') as $k => $value)
                <option value="{{ $k }}" {{$k == $param['group'] ? 'selected' : ''}} >{{ $value }}</option>
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
