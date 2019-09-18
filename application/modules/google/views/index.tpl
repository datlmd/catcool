<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">{lang('dashboard_heading')}</h2>
				<p class="pageheader-text"></p>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
                        {$this->breadcrumb->render()}
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('dashboard_heading')}</h5>
				<div class="card-body">
					<!-- Step 1: Create the containing elements. -->

					<section id="auth-button"></section>
					<section id="view-selector"></section>
					<section id="timeline"></section>

				</div>
			</div>
		</div>
	</div>
</div>




<!-- Step 2: Load the library. -->
{literal}
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-61959385-1"></script>
	<script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-61959385-1');
	</script>


	<script>
    (function(w,d,s,g,js,fjs){
        g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
        js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
        js.src='https://apis.google.com/js/platform.js';
        fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
    }(window,document,'script'));
</script>

<script>
    gapi.analytics.ready(function() {

        // Step 3: Authorize the user.

        var CLIENT_ID = '515995961004-s81g7n2nbcf867i4pous2h346akgs8iq.apps.googleusercontent.com';

        gapi.analytics.auth.authorize({
            container: 'auth-button',
            clientid: CLIENT_ID,
        });

        // Step 4: Create the view selector.

        var viewSelector = new gapi.analytics.ViewSelector({
            container: 'view-selector'
        });

        // Step 5: Create the timeline chart.

        var timeline = new gapi.analytics.googleCharts.DataChart({
            reportType: 'ga',
            query: {
                'dimensions': 'ga:date',
                'metrics': 'ga:sessions',
                'start-date': '30daysAgo',
                'end-date': 'yesterday',
            },
            chart: {
                type: 'LINE',
                container: 'timeline'
            }
        });

        // Step 6: Hook up the components to work together.

        gapi.analytics.auth.on('success', function(response) {
            viewSelector.execute();
        });

        viewSelector.on('change', function(ids) {
            var newIds = {
                query: {
                    ids: ids
                }
            }
            timeline.set(newIds).execute();
        });
    });
</script>
{/literal}
