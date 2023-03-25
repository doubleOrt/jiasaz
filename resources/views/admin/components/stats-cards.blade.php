
<div class="col-md-12">
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <!-- CHART-->
        <div class="statistic-chart-1">
            <h3 class="title-3 m-b-30">Quantity Sold</h3>
            <div class="chart-wrap"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="quantitySoldInLastTwelveMonthsChart" height="231" style="display: block; height: 154px; width: 210px;" width="315" class="chartjs-render-monitor"></canvas>
            </div>
            <div class="statistic-chart-1-note">
                <span id="quantitySoldText" class="big">Total 10000 Sold</span>
            </div>
        </div>
        <!-- END CHART-->
    </div>

    <div class="col-md-6 col-lg-4">
        <!-- CHART-->
        <div class="statistic-chart-1">
            <h3 class="title-3 m-b-30">Value</h3>
            <div class="chart-wrap"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="valueSoldInLastTwelveMonthsChart" height="231" style="display: block; height: 154px; width: 210px;" width="315" class="chartjs-render-monitor"></canvas>
            </div>
            <div class="statistic-chart-1-note">
                <span id="valueSoldText" class="big">Total $100000 sold</span>
            </div>
        </div>
        <!-- END CHART-->
    </div>

</div>
</div>

<div class="col-md-12">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">

          <!-- TOP Categories -->
          <div class="top-campaign">
              <h3 class="title-3 m-b-30">top categories</h3>
              <div class="table-responsive">
                  <table class="table table-top-campaign">
                      <tbody>
                          @for($i = 0; $i < sizeof($top_categories); $i++) 
                              <tr>
                                  <td>{{$i+1}}. {{$top_categories[$i]["category_name"]}}</td>
                                  <td>{{$top_categories[$i]["total_orders"]}} <small class="text-secondary">Orders</small></td>
                              </tr>
                          @endfor
                      </tbody>
                  </table>
              </div>
          </div>
          <!-- END TOP CATEGORIES-->
      </div>


      <div class="col-md-6 col-lg-4">
          <!-- TOP SHOPS -->
          <div class="top-campaign">
              <h3 class="title-3 m-b-30">top shops</h3>
              <div class="table-responsive">
                  <table class="table table-top-campaign">
                      <tbody>
                          @for($i = 0; $i < sizeof($top_shops); $i++) 
                              <tr>
                                  <td>{{$i+1}}. {{$top_shops[$i]["first_name"]}}</td>
                                  <td>{{$top_shops[$i]["total_orders"]}} <small class="text-secondary">Orders</small></td>
                              </tr>
                          @endfor
                      </tbody>
                  </table>
              </div>
          </div>
          <!-- END TOP SHOPS -->
      </div>
      
  </div>
</div>

<div class="col-md-6 col-lg-4">
    <!-- CHART PERCENT-->
    <div class="chart-percent-2">
        <h3 class="title-3 m-b-30">chart by %</h3>
        <div class="chart-wrap"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <canvas id="percent-chart2" height="313" style="display: block; height: 209px; width: 210px;" width="315" class="chartjs-render-monitor"></canvas>
            <div id="chartjs-tooltip">
                <table></table>
            </div>
        </div>
        <div class="chart-info">
            <div class="chart-note">
                <span class="dot dot--blue"></span>
                <span>products</span>
            </div>
            <div class="chart-note">
                <span class="dot dot--red"></span>
                <span>Services</span>
            </div>
        </div>
    </div>
    <!-- END CHART PERCENT-->
</div>

<script>


try {
    //WidgetChart 5
    var ctx = document.getElementById("quantitySoldInLastTwelveMonthsChart");
    let months = [
        @foreach($last_twelve_months_data as $month_data)
            {!! '"' . $month_data["month_name"] . '",' !!}
        @endforeach
    ];
    let quantitySold = [
        @foreach($last_twelve_months_data as $month_data)
            {!! '"' . $month_data["quantity_sold"] . '",' !!}
        @endforeach
    ];
    months = months.reverse();
    quantitySold = quantitySold.reverse();
    console.log(months);
    console.log(quantitySold);
    if (ctx) {
      ctx.height = 220;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months,
          datasets: [
            {
              label: "My First dataset",
              data: quantitySold,
              borderColor: "transparent",
              borderWidth: "0",
              backgroundColor: "#ccc",
            }
          ]
        },
        options: {
          maintainAspectRatio: true,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              display: false,
              categoryPercentage: 1,
              barPercentage: 0.65
            }],
            yAxes: [{
              display: false
            }]
          }
        }
      });
    }

  } catch (error) {
    console.error(error);
  }

  
try {
    //WidgetChart 5
    var ctx = document.getElementById("valueSoldInLastTwelveMonthsChart");
    let months = [
        @foreach($last_twelve_months_data as $month_data)
            {!! '"' . $month_data["month_name"] . '",' !!}
        @endforeach
    ];
    let valueSold = [
        @foreach($last_twelve_months_data as $month_data)
            {!! '"' . $month_data["value_sold"] . '",' !!}
        @endforeach
    ];
    months = months.reverse();
    valueSold = valueSold.reverse();
    console.log(months);
    console.log(valueSold);
    if (ctx) {
      ctx.height = 220;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months,
          datasets: [
            {
              label: "My First dataset",
              data: valueSold,
              borderColor: "transparent",
              borderWidth: "0",
              backgroundColor: "#ccc",
            }
          ]
        },
        options: {
          maintainAspectRatio: true,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              display: false,
              categoryPercentage: 1,
              barPercentage: 0.65
            }],
            yAxes: [{
              display: false
            }]
          }
        }
      });
    }

  } catch (error) {
    console.error(error);
  }


</script>