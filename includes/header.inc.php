<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Jekyll v4.1.1">
	<title><?=(isset($html['title']) ? $html['title'] : '')?></title>
	<!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/"> -->

	<!-- Bootstrap core CSS -->
	<link href="<?=BASE_URL?>assets/vendor/bootstrap-4.5.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">


	<!-- Favicons -->


    <!-- Custom -->
    <link href="<?=BASE_URL?>assets/css/developer.css" rel="stylesheet">



</head>
<body>
	<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow"> <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Loot Chest</a>
		<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
		<ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap"> <a class="nav-link" href="#">Sign out</a> </li>
		</ul>

	</nav>
	<div class="container-fluid">
		<div class="row">

			<!-- <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
				<div class="sidebar-sticky pt-3">

					<h4></h4>
					<ul class="nav flex-column">

						<li class="nav-item">
							<a class="nav-link" href="/helpdesk/admin/index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/helpdesk/admin/import/index.php">Import</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/helpdesk/admin/scan/index.php">Scan</a>
						</li>

					</ul>

				</div>
			</nav> -->

			<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4">

				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<style>
.menu a {
    display: inline-block;
    padding: 5px 10px;
    border: 1px solid #26abff;
    min-width: 100px;
    text-align: center;
}
</style>

				<div class="menu">
					<a class="" href="/helpdesk/admin/index.php">Home</a>
            		<a class="" href="/helpdesk/admin/import/index.php">Import</a>
            		<a class="" href="/helpdesk/admin/search/index.php">Search</a>

					<a class="" href="/helpdesk/admin/search/insert.php">Insert</a>
					<a class="" href="/helpdesk/admin/search/update.php">Update</a>
				</div>

					<div class="btn-toolbar mb-2 mb-md-0">
						<div class="btn-group mr-2">
							<button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
							<button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
						</div>
						<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
						<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
						<line x1="16" y1="2" x2="16" y2="6"></line>
						<line x1="8" y1="2" x2="8" y2="6"></line>
						<line x1="3" y1="10" x2="21" y2="10"></line>
						</svg> This week </button>
					</div>

				</div>

