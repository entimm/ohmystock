@extends('layouts')

@push('csses')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet">
<style>
    .col-md-6 {
        padding-right: 5px;
        padding-left: 5px;
    }
</style>
@endpush

@section('right_nav')
<form class="form-inline mt-2 mt-md-0" action="/monitor">
  <select class="form-control mr-sm-2" name="group">
      @foreach (config('stock.groups') as $k => $value)
          <option value="{{ $k }}" {{$k == $param['group'] ? 'selected' : ''}} >{{ $value }}</option>
      @endforeach
    </select>
  <input class="form-control mr-sm-2" name="date" type="text" id="datepicker" value="{{$param['date']}}">
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">GO</button>
</form>
@endsection

@section('content')
<div class="container">
  <div class="row">
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('#datepicker').datepicker({});

    function createConfig(code, data) {
        var color = Chart.helpers.color;
        return {
            type: 'line',
            data: {
                labels: data.dates[code],
                datasets: [{
                    label: '开盘',
                    borderColor: '#A5D6A7',
                    backgroundColor: color('#A5D6A7').alpha(0.2).rgbString(),
                    data: data.open[code],
                    fill: 1,
                    borderWidth: 2,
                }, {
                    label: '收盘',
                    borderColor: '#F48FB1',
                    backgroundColor: color('#F48FB1').alpha(0.2).rgbString(),
                    data: data.close[code],
                    fill: 2,
                    borderWidth: 2,
                }, {
                    label: '最高',
                    borderColor: '#90CAF9',
                    backgroundColor: color('#90CAF9').alpha(0.2).rgbString(),
                    data: data.high[code],
                    fill: 3,
                    borderWidth: 2,
                    borderDash: [4, 2],
                }, {
                    label: '最低',
                    borderColor: '#B39DDB',
                    backgroundColor: color('#B39DDB').alpha(0.2).rgbString(),
                    data: data.low[code],
                    fill: 4,
                    borderWidth: 2,
                    borderDash: [4, 2],
                }]
            }, options: {
                responsive: true,
                title: {
                    display: true,
                    text: data.names[code],
                },
                tooltips: {
                    mode: 'index',
                },
                hover: {
                    mode: 'index'
                },
                legend: {
                    labels: {
                      usePointStyle: true,
                    }
                },
            },
        };
    }

    var group = $('[name=group]').val();
    var date = $('[name=date]').val();
    window.axios.get('/api/date_klines', {params: {group: group, date: date}}).then((response) => {
        var container = document.querySelector('.container .row');
        for(var code in response.data.names) {
            var div = document.createElement('div');
            div.classList.add('col-md-6');
            var box = document.createElement('div');
            box.classList.add('box');
            var canvas = document.createElement('canvas');
            box.appendChild(canvas);
            div.appendChild(box);
            container.appendChild(div);

            var ctx = canvas.getContext('2d');
            var config = createConfig(code, response.data);
            new Chart(ctx, config);
        }
    });
  });
</script>
@endpush