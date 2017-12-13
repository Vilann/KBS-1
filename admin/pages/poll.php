<html lang="en">
      <?php include '../header.php';?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="poll">ZHTC Poll<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <div class="row">
              <div class="col-md-11">
                <p class="text-muted">
                  Hieronder vind je de resultaten van de afgelopen 3 polls
                </p>
              </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-md-4 border border-primary rounded zhtc-brd-2">
                  <div id="pollResultaten" ></div>
                  <button type="button" class="btn btn-outline-primary mb-3 zhtc-button float-right">Meer info</button>
                </div>
                <div class="col-md-3">
                  <div id="pollResultaten2" ></div>
                </div>
                <div class="col-md-3">
                  <div id="pollResultaten3" ></div>
                </div>
            </div>
            <hr>
        </main>
        <!-- Modal om overige poll gegevens in te laden -->
        <div class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Modal body text goes here.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>

        <script type="text/javascript">
        $(function () {
          Highcharts.setOptions({
           colors: ['#b3d6ff', '#3392ff', '#005fcc', '#004799', '#003878', '#003066', '#001833', '#000c1a']
          });
          // Build the chart
          Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Browser market shares January, 2015 to May, 2015'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Microsoft Internet Explorer',
                    y: 56.33
                }, {
                    name: 'Chrome',
                    y: 24.03,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Firefox',
                    y: 10.38
                }, {
                    name: 'Safari',
                    y: 4.77
                }, {
                    name: 'Opera',
                    y: 0.91
                }, {
                    name: 'Proprietary or Undetectable',
                    y: 0.2
                }]
            }]
        });
          Highcharts.chart('pollResultaten', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Wie moet de nieuwe voorzitten worden?'
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                    }
                }
            },
            exporting: { enabled: false },
            series: [{
                name: 'Leden',
                colorByPoint: true,
                data: [{
                    name: 'Jelmar',
                    y: 40
                }, {
                    name: 'Harrie',
                    y: 25,
                }, {
                    name: 'Henk',
                    y: 15
                }, {
                    name: 'Jacob',
                    y: 10
                }, {
                    name: 'Anders',
                    y: 10
                }]
            }]
        });


        Highcharts.chart('pollResultaten2', {
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
          title: {
              text: 'Wie moet de oude voorzitten worden?'
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          credits: {
              enabled: false
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false,
                  }
              }
          },
          exporting: { enabled: false },
          series: [{
              name: 'Leden',
              colorByPoint: true,
              data: [{
                  name: 'Jelmar',
                  y: 56.33
              }, {
                  name: 'Harrie',
                  y: 24.03,
              }, {
                  name: 'Henk',
                  y: 10.38
              }, {
                  name: 'Jacob',
                  y: 4.77
              }, {
                  name: 'Julie',
                  y: 0.91
              }, {
                  name: 'Anders',
                  y: 0.2
              }]
          }]
      });

      Highcharts.chart('pollResultaten3', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Waarom zijn de bananen krom?'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false,
                }
            }
        },
        exporting: { enabled: false },
        series: [{
            name: 'banaan',
            colorByPoint: true,
            data: [{
                name: 'Anders vallen ze om?',
                y: 40
            }, {
                name: 'Zonlicht ofzo ga mij niet vragen..',
                y: 25,
            }, {
                name: 'Misbruik test banaan',
                y: 20
            }, {
                name: 'Geen idee ben te dronken om te antwoorden',
                y: 15
            }]
        }]
    });
    });
        </script>
      </body>
</html>
