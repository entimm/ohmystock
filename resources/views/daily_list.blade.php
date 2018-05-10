@extends('layouts')

@push('csses')
<style>
    .box.box-default {
        border-top-color: #d2d6de;
    }
    .box {
        border-radius: 3px;
        background: #ffffff;
        border-top: 3px solid #d2d6de;
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }
    .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative;
    }
    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
    }
    .box-footer {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        border-top: 1px solid #f4f4f4;
        padding: 10px;
        background-color: #fff;
    }
    .box-header .box-title {
        display: inline-block;
        font-size: 18px;
        margin: 0;
        line-height: 1;
    }

    .box-header {
        background-color: #6f42c1;
        color: #fff;
    }

    .grid-item { 
        width: 33%;
        min-width: 350px;
    }
</style>
@endpush

@section('right_nav')
<form class="form-inline mt-2 mt-md-0" action="/daily_list" id="nav-form">
  <select class="form-control mr-sm-2" name="group" onchange="event.preventDefault();document.getElementById('nav-form').submit();">
      @foreach (config('stock.groups') as $k => $value)
          <option value="{{ $k }}" {{$k == $param['group'] ? 'selected' : ''}} >{{ $value }}</option>
      @endforeach
    </select>
</form>
@endsection

@section('content')
<div class="container table-responsive">
  <div class="grid">
    @foreach ($monitors as $date => $items)
    <div class="box grid-item">
        <div class="box-header">
            <h3 class="text-center">{{$date}}</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td> {{ $item->code }} </td>
                        <td> {{ $item->name }} </td>
                        <td> {{ $item->start }} </td>
                        <td> <button type="button" class="btn btn-sm btn-outline-danger remove" data-id="{{ $item->id }}">删除</button> </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
    $(function() {
        $('.grid').masonry({
          itemSelector: '.grid-item',
          columnWidth: 10
        });

        $('.remove').on('click', function() {
            var id = $(this).data('id');
            window.axios.post('/api/remove', {id: id}).then((response) => {
                location.reload();
            });
        });
    });
</script>
@endpush