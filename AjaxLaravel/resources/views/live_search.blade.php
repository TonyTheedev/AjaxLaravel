@extends('layouut')

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

@section('content')
<div class="container box">
	<h3 align="center"> Recherche live  en laravel en utilisant AJAX</h3>
	<br />
	<div class="panel panel-default">
		<div class="panel-heading">Rechercher !</div>
		<div class="panel-body">
			<div class="form-group">
				<input type="text" name="search" id="search" class="form-control" placeholder="Rechercher Personne" />
				<select id="MonSelect" class="form-control">
					<option>Ad</option>
					<option>O</option>
					<option>hi</option>
				</select>
				<span id="MonSpan"></span>
			</div>
			<div class="table-responsive">
				<h3 align="center">
					Total Data :
					<span id="total_records"></span>
				</h3>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>Date de naissance</th>
							<th>Sexe</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				{{ csrf_field() }}
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="js/jquery.js"></script>

<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function () {

		fetch_customer_data();

		function fetch_customer_data(query = '') {
			$.ajax({
				url: "{{ route('live_search.action') }}",
				method: 'GET',
				data: { query: query },
				dataType: 'json',
				success: function (data) {
					$('tbody').html(data.table_data);
					$('#total_records').text(data.total_data);
				}
			});
		}

		function import_nom(queryy = '') {
			$.ajax({
				url: "{{ route('live_search.actionn') }}",
				method: 'GET',
				data: { query: queryy },
				dataType: 'json',
				success: function (data) {
					$('#MonSpan').html(data.LesDonnee);
				},
			});
		}

		$(document).on('change', '#MonSelect', function () {
			var info = this.value;
				import_nom(info);
			});

		$(document).on('keyup', '#search', function () {
			var query = $(this).val();
			fetch_customer_data(query);
		});
	});
</script>
@endsection
