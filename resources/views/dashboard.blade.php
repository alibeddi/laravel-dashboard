@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back()" class="back-link"><span class="back-chevron"></span> Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="header-grid">
                        <div class="header-left">
                            <h2 class="card-title mb-0">Revenue</h2>
                        </div>
                        <div class="header-center text-center">
                            <div class="pill-switch" role="group" aria-label="MRR/ARPU">
                                <button id="btn-mrr" type="button" class="pill active">MRR</button>
                                <button id="btn-arpu" type="button" class="pill">ARPU</button>
                            </div>
                        </div>
                        <div class="header-right d-flex align-items-center justify-content-end">
                            <label class="date-pill mr-3 mb-0">
                                <span class="date-dot"></span>
                                <input id="date-input" type="date" value="2024-01-19" />
                            </label>
                            <select id="period-select" class="period-pill">
                                <option value="7">Last 7 Days</option>
                                <option value="14">Last 14 Days</option>
                                <option value="30" selected>Last 30 Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="metric-grid mt-3">
                        <div class="metric"><div class="label">Total MRR</div><div class="value">$14,775</div></div>
                        <div class="metric"><div class="label">New MRR</div><div class="value">$14,775</div></div>
                        <div class="metric"><div class="label">Upgrades</div><div class="value">$13,000</div></div>
                        <div class="metric"><div class="label">Downgrades</div><div class="value">$755</div></div>
                        <div class="metric"><div class="label">ARPU</div><div class="value">$10,000</div></div>
                        <div class="metric"><div class="label">Reactivations</div><div class="value">$10,000</div></div>
                        <div class="metric"><div class="label">Existing</div><div class="value">$10,000</div></div>
                        <div class="metric"><div class="label">Churn</div><div class="value">$100</div></div>
                    </div>
                    <div class="legend-row mt-2">
                        <span class="dot" style="--c:#c0392b"></span> Total MRR
                        <span class="dot" style="--c:#5468ff"></span> New MRP
                        <span class="dot" style="--c:#3b82f6"></span> Reactivations
                        <span class="dot" style="--c:#22c55e"></span> Upgrades
                        <span class="dot" style="--c:#7c83ff"></span> Existing
                        <span class="dot" style="--c:#8b5cf6"></span> Downgrades
                        <span class="dot" style="--c:#ff4dcc"></span> Churn
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area position-relative">
                        <canvas id="revenueChart"></canvas>
                        <div id="chart-tooltip" class="chart-tooltip" style="display:none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
    (function() {
        var ctx = document.getElementById('revenueChart').getContext('2d');
        function genLabels(days) {
          var out = [];
          for (var i=1;i<=days;i++) out.push(i+' Jan');
          return out;
        }
        function genSeq(start, step, len) { return Array.from({length: len}, (_,i)=> start + i*step); }
        function loadMRRData(days){
          return {
            labels: genLabels(days),
            newMrr: genSeq(200,20,days),
            upgrades: genSeq(300,20,days),
            reactivations: genSeq(150,10,days),
            existing: genSeq(2200,100,days),
            downgrades: genSeq(80,10,days),
            churn: genSeq(70,5,days)
          };
        }
        function loadARPUData(days){
          return { labels: genLabels(days), arpu: genSeq(10,1,days) };
        }

        var period = parseInt(document.getElementById('period-select').value,10);
        var mrrData = loadMRRData(period);

        var tooltipEl = document.getElementById('chart-tooltip');
        var currentMode = 'MRR';
        function externalTooltip(context) {
          var tooltip = context.tooltip;
          if (!tooltip) return;
          if (tooltip.opacity === 0) { tooltipEl.style.display = 'none'; return; }
          var title = tooltip.title && tooltip.title[0] ? tooltip.title[0] : '';
          var bodyLines = tooltip.body ? tooltip.body.map(b => b.lines).flat() : [];
          var rows = bodyLines.map(function(line){ return '<div class="tt-row">'+line+'</div>'; }).join('');
          tooltipEl.innerHTML = '<div class="tt-card"><div class="tt-header">MRR Breakdown<span class="tt-date">'+title+'</span></div><div class="tt-body">'+rows+'</div></div>';
          tooltipEl.style.display = 'block';
          var rect = context.chart.canvas.getBoundingClientRect();
          tooltipEl.style.left = rect.left + window.pageXOffset + tooltip.caretX - 150 + 'px';
          tooltipEl.style.top  = rect.top  + window.pageYOffset + tooltip.caretY - 160 + 'px';
        }

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: mrrData.labels,
                datasets: [
                    {label: 'Churn', backgroundColor: '#ff4dcc', data: mrrData.churn, stack: 'mrr'},
                    {label: 'Downgrades', backgroundColor: '#8b5cf6', data: mrrData.downgrades, stack: 'mrr'},
                    {label: 'Existing', backgroundColor: '#5468ff', data: mrrData.existing, stack: 'mrr'},
                    {label: 'Reactivations', backgroundColor: '#3b82f6', data: mrrData.reactivations, stack: 'mrr'},
                    {label: 'Upgrades', backgroundColor: '#22c55e', data: mrrData.upgrades, stack: 'mrr'},
                    {label: 'New MRR', backgroundColor: '#c0392b', data: mrrData.newMrr, stack: 'mrr'}
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                tooltips: { enabled: false, mode: 'index', intersect: false, custom: externalTooltip, callbacks: {
                    label: function(item, data) {
                      var ds = data.datasets[item.datasetIndex];
                      var label = ds.label || '';
                      var value = ds.data[item.index];
                      return label + '  $' + value.toLocaleString();
                    }
                }},
                scales: {
                    xAxes: [{
                        stacked: true,
                        ticks: { fontColor: '#9aa4b2' },
                        gridLines: { color: 'rgba(255,255,255,0.06)', zeroLineColor: 'rgba(255,255,255,0.06)' }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: { fontColor: '#9aa4b2', beginAtZero: true, callback: function(v){ return v >= 1000 ? (v/1000)+'k' : v; } },
                        gridLines: { color: 'rgba(255,255,255,0.06)', zeroLineColor: 'rgba(255,255,255,0.06)' }
                    }]
                }
            }
        });

        // Toggle between MRR and ARPU demo datasets
        document.getElementById('btn-mrr').addEventListener('click', function(){
          if (currentMode === 'MRR') return;
          currentMode = 'MRR';
          this.classList.add('active');
          document.getElementById('btn-arpu').classList.remove('active');
          var days = parseInt(document.getElementById('period-select').value,10);
          var d = loadMRRData(days);
          chart.data.labels = d.labels;
          chart.data.datasets = [
            {label: 'Churn', backgroundColor: '#ff4dcc', data: d.churn, stack: 'mrr'},
            {label: 'Downgrades', backgroundColor: '#8b5cf6', data: d.downgrades, stack: 'mrr'},
            {label: 'Existing', backgroundColor: '#5468ff', data: d.existing, stack: 'mrr'},
            {label: 'Reactivations', backgroundColor: '#3b82f6', data: d.reactivations, stack: 'mrr'},
            {label: 'Upgrades', backgroundColor: '#22c55e', data: d.upgrades, stack: 'mrr'},
            {label: 'New MRR', backgroundColor: '#c0392b', data: d.newMrr, stack: 'mrr'}
          ];
          chart.update();
        });
        document.getElementById('btn-arpu').addEventListener('click', function(){
          if (currentMode === 'ARPU') return;
          currentMode = 'ARPU';
          this.classList.add('active');
          document.getElementById('btn-mrr').classList.remove('active');
          var days = parseInt(document.getElementById('period-select').value,10);
          var d = loadARPUData(days);
          chart.data.labels = d.labels;
          chart.data.datasets = [{ label: 'ARPU', backgroundColor: '#575BC7', data: d.arpu, stack: 'arpu' }];
          chart.update();
        });

        // Period filter
        document.getElementById('period-select').addEventListener('change', function(){
          var days = parseInt(this.value,10);
          if (currentMode === 'MRR') {
            var d = loadMRRData(days);
            chart.data.labels = d.labels;
            chart.data.datasets[0].data = d.churn;
            chart.data.datasets[1].data = d.downgrades;
            chart.data.datasets[2].data = d.existing;
            chart.data.datasets[3].data = d.reactivations;
            chart.data.datasets[4].data = d.upgrades;
            chart.data.datasets[5].data = d.newMrr;
          } else {
            var d2 = loadARPUData(days);
            chart.data.labels = d2.labels;
            chart.data.datasets[0].data = d2.arpu;
          }
          chart.update();
        });
    })();
    </script>
@endpush
