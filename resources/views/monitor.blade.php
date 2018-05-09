<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OH MY STOCK</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <style>
        .box {
            padding: 5px;
            margin: 5px 0px;
            background: white;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
        }
        .col-md-6 {
            padding-right: 5px;
            padding-left: 5px;
        }
    </style>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">OH MY STOCK</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <form class="form-inline mt-2 mt-md-0">
            <select class="form-control mr-sm-2" name="group">
                <option value="">选择分组</option>
                @foreach (config('stock.groups') as $k => $value)
                    <option value="{{ $k }}" {{$k == $param['group'] ? 'selected' : ''}} >{{ $value }}</option>
                @endforeach
              </select>
            <input class="form-control mr-sm-2" name="date" type="text" id="datepicker" value="{{$param['date']}}">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">GO</button>
          </form>
        </div>
      </nav>
    </header>
    <main role="main" id="app">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </main>
    <script src="js/app.js"></script>
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
                        borderColor: '#F48FB1',
                        backgroundColor: color('#F48FB1').alpha(0.1).rgbString(),
                        data: data.open[code],
                        fill: true,
                        borderWidth: 2,
                    }, {
                        label: '收盘',
                        borderColor: '#B39DDB',
                        backgroundColor: color('#B39DDB').alpha(0.1).rgbString(),
                        data: data.close[code],
                        fill: true,
                        borderWidth: 2,
                    }, {
                        label: '最高',
                        borderColor: '#90CAF9',
                        backgroundColor: color('#90CAF9').alpha(0.1).rgbString(),
                        data: data.high[code],
                        fill: true,
                        borderWidth: 2,
                        borderDash: [4, 2],
                    }, {
                        label: '最低',
                        borderColor: '#C5E1A5',
                        backgroundColor: color('#C5E1A5').alpha(0.1).rgbString(),
                        data: data.low[code],
                        fill: true,
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
                },
            };
        }

        var group = $('[name=group]').val();
        var date = $('[name=date]').val();
        window.axios.get('/api/date_kline', {params: {group: group, date: date}}).then((response) => {
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
  </body>
</html>
