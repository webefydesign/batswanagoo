<!doctype html>
<html lang="en">

<head>
  <title>
    Salonegoo
  </title>
  <!--== META TAGS ==-->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="theme-color" content="#76cef1" />
  <meta property="og:image" content="" />
  <meta name="description" content="">
  <meta name="keyword" content="">
  <!--== FAV ICON(BROWSER TAB ICON) ==-->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!--== GOOGLE FONTS ==-->
  <link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">
  <!--== WEB ICON FONTS ==-->
  <link rel="preload" as="font" href="css/icon.woff2" type="font/woff2" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--== CSS FILES ==-->
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/theme-color.php">
  <link rel="stylesheet" href="css/awesome.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="css/performance.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">

  <!--  <link rel="stylesheet" href="css/fonts.css"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
  <!--    Google Analytics Code Starts-->
  <!-- Global site tag (gtag.js) - Google Analytics -->

  <style type="text/css">
    .full-bot-book {
      display: none;
    }
  </style>
</head>

<body>
  <!--    Google Ad Sense Code Starts-->
  <!--    Google Ad Sense Code Ends-->
  <!-- Preloader -->
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
  <?php include('includes/header.php'); ?>
  <!-- START -->



  <section class="all-list-bre searchbanner" style="background-image: url('img/electronices.jpg');">
    <div class="container sec-all-list-bre perf">
      <div class="row">
        <ul>
          <li><a href="#">Back to Search</a>
          </li>
          <li><span>Performance</span>
          </li>
        </ul>
        <h2 style="visibility: hidden;">Performance</h2>
        <!-- <h1>Performance</h1> -->

        <div class="performance">
          <div class="per-title">
            <h1>Performance</h1>
          </div>
          
        </div><!-- performance -->

       
      </div>
    </div>
  </section>



  <section class="chartWrapper">
    <div class="container">
      <div class="chart-container">
        <div class="legend-container" id="legend-container"></div>
        <canvas id="myChart"></canvas>
        <div id="stats-container" class="stats"></div>
      </div>
    </div>
  </section>








  <?php include('includes/footer.php'); ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/select-opt.js"></script>
  <script type="text/javascript">
    var webpage_full_link = '';
  </script>
  <script type="text/javascript">
    var login_url = 'login?src=jobs/';
  </script>
  <script src="js/slick.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/custom_validation.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // ----------
    // Data
    // ----------
    function randomIntFromInterval(min, max) { // min and max included
      return Math.floor(Math.random() * (max - min + 1) + min)
    }

    const labels = [];
    const data_impressions = [];
    const data_visitors = [];
    const data_phone_view = [];
    const data_chat_requests = [];
    for (i = 1; i <= 31; i++) {
      labels.push('Jan ' + i);
      data_impressions.push(randomIntFromInterval(1000, 3000));
      data_visitors.push(randomIntFromInterval(600, 1000));
      data_phone_view.push(randomIntFromInterval(100, 300));
      data_chat_requests.push(randomIntFromInterval(50, 150));
    }

    const data = {
      labels: labels,
      datasets: [{
          label: 'Impressions',
          data: data_impressions,
          borderColor: 'black',
          backgroundColor: 'black',
          borderWidth: 1,
        },
        {
          label: 'Visitors',
          data: data_visitors,
          borderColor: '#ccc',
          backgroundColor: '#ccc',
          borderWidth: 1,
        },
        {
          label: 'Phone View',
          data: data_phone_view,
          borderColor: 'orange',
          backgroundColor: 'orange',
          borderWidth: 1,
        },
        {
          label: 'Chat Requests',
          data: data_chat_requests,
          borderColor: 'red',
          backgroundColor: 'red',
          borderWidth: 1,
        }
      ]
    };

    var statTotals = [
      {cssClass:'impressions', value: 21333},  // Impressions
      {cssClass:'visitors', value: 12345},  // Visitors
      {cssClass:'phone_views', value: 54693},  // Phone View
      {cssClass:'chat_requests', value: 25852}   // Chat Requests
    ];






    // ----------
    // Custom Legend on top right
    // ----------
    const getOrCreateLegendList = (chart, id) => {
      const legendContainer = document.getElementById(id);
      let listContainer = legendContainer.querySelector('ul');

      if (!listContainer) {
        listContainer = document.createElement('ul');
        legendContainer.appendChild(listContainer);
      }

      return listContainer;
    };

    const htmlLegendPlugin = {
      id: 'htmlLegend',
      afterUpdate(chart, args, options) {
        const ul = getOrCreateLegendList(chart, options.containerID);

        const statsContainer = document.getElementById('stats-container');
        statsContainer.textContent = ''; 

        // Remove old legend items
        while (ul.firstChild) {
          ul.firstChild.remove();
        }

        // Reuse the built-in legendItems generator
        const items = chart.options.plugins.legend.labels.generateLabels(chart);

        items.forEach(item => {
          const li = document.createElement('li');

          if (item.hidden) {
            li.classList.add("hidden"); 
          } else {
            li.classList.remove("hidden"); 
          }

          li.onclick = () => {
            const {
              type
            } = chart.config;
            if (type === 'pie' || type === 'doughnut') {
              // Pie and doughnut charts only have a single dataset and visibility is per item
              chart.toggleDataVisibility(item.index);
            } else {
              chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
            }
            chart.update();
          };

          console.log(item);

          // li Color box
          const boxSpan = document.createElement('span');
          boxSpan.style.background = item.fillStyle;
          boxSpan.style.borderColor = item.strokeStyle;
          boxSpan.style.borderWidth = item.lineWidth + 'px';

          // li Text
          const textContainer = document.createElement('p');
          textContainer.style.color = item.fontColor;
          textContainer.style.textDecoration = item.hidden ? 'line-through' : '';

          const text = document.createTextNode(item.text);
          textContainer.appendChild(text);

          li.appendChild(boxSpan);
          li.appendChild(textContainer);
          ul.appendChild(li);

          // Stats Div
          const divStat = document.createElement('div');
          divStat.classList.add("stat");
          divStat.classList.add(window.statTotals[item.datasetIndex].cssClass);
          divStat.style.background = item.fillStyle;
          divStat.style.borderColor = item.strokeStyle;

          // Hidden or not
          if (item.hidden) { 
            divStat.classList.add("hidden");
          } else { 
            divStat.classList.remove("hidden");
          }

          // On Click
          divStat.onclick = () => {
            const {
              type
            } = chart.config;
            if (type === 'pie' || type === 'doughnut') {
              // Pie and doughnut charts only have a single dataset and visibility is per item
              chart.toggleDataVisibility(item.index);
            } else {
              chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
            }
            chart.update();
          };

          // Span for total number
          const spanNum = document.createElement('span');
          const spanNumText = document.createTextNode(window.statTotals[item.datasetIndex].value);
          spanNum.append(spanNumText);
          divStat.append(spanNum);

          // Strong for stat label
          const strongLabel = document.createElement('strong');
          const strongLabelText = document.createTextNode(item.text);
          strongLabel.append(strongLabelText);
          divStat.appendChild(strongLabel);

          console.log('divStat', divStat);
          statsContainer.append(divStat);

        }); // Foreach iems
      }
    };











    // ----------
    // Now construct the chart
    // ----------
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
      type: 'line',
      data: data,
      plugins: [htmlLegendPlugin],
      options: {
        responsive: true,
        plugins: {
          htmlLegend: {
            // ID of the container to put the legend in
            containerID: 'legend-container',
          },
          legend: {
            display: false,
          },
          title: {
            display: true,
            text: '', // 'Chart.js Line Chart'
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            grid: {
              display: false
            }
          }
        }

      },
    });
  </script>

  <!-- MDB -->
</body>

</html>