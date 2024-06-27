@include('template.header')
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-6 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Grafik Keuangan</h5>
                  </div>
                  <div>
                    <form action="{{ route('dashboard') }}" method="GET"  enctype="multipart/form-data" class="d-flex">
                        <select class="form-select me-2" name="bulanKeuangan">
                            @foreach($months as $value)
                                @if($value == $bulanTahun)
                                <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </form>
                  </div>
                </div>
                <div id="chart"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Grafik Ikan Hidup Dan Mati</h5>
                  </div>
                  <div>
                  </div>
                </div>
                <div id="chart2"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <!-- <script src="../assets/js/dashboard.js"></script> -->
  <script>
    var options = {
    chart: {
      type: 'bar'
    },
    series: [{
      name: 'Jumlah Ikan Mati',
      data: @json($ikanMati)
    },
    {
      name: 'Jumlah Ikan Hidup',
      data: @json($ikanHidup)
    }],
    xaxis: {
      categories: @json($namaKolam)
    }
  }

  var chart = new ApexCharts(document.querySelector("#chart2"), options);

  chart.render();
    var dates = @json($dates);

    console.log(dates);

    var chart = {
        series: [
            {
                name: "Pemasukan:",
                data: @json($pemasukan),
            },
            {
                name: "Pengeluaran:",
                data: @json($pengeluaran),
            },
        ],

        chart: {
            type: "bar",
            height: 345,
            offsetX: -15,
            toolbar: { show: true },
            foreColor: "#adb0bb",
            fontFamily: "inherit",
            sparkline: { enabled: false },
        },

        colors: ["#5D87FF", "#49BEFF"],

        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "35%",
                borderRadius: [6],
                borderRadiusApplication: "end",
                borderRadiusWhenStacked: "all",
            },
        },
        markers: { size: 0 },

        dataLabels: {
            enabled: false,
        },

        legend: {
            show: false,
        },

        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false,
                },
            },
        },

        xaxis: {
            type: "category",
            categories: @json($dates),
            labels: {
                style: { cssClass: "grey--text lighten-2--text fill-color" },
            },
        },

        yaxis: {
            show: true,
        },
        stroke: {
            show: true,
            width: 3,
            lineCap: "butt",
            colors: ["transparent"],
        },

        tooltip: { theme: "light" },

        responsive: [
            {
                breakpoint: 600,
                options: {
                    plotOptions: {
                        bar: {
                            borderRadius: 3,
                        },
                    },
                },
            },
        ],
    };

    var chart = new ApexCharts(document.querySelector("#chart"), chart);
    chart.render();
  </script>
</body>

</html>
