<?php require_once __DIR__.'/../init.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Agenda</title>
	<?php if (DEV): ?>
		<script src="/js-dev/require.js" data-main="/js-dev/app"></script>
	<?php else: ?>
		<script src="/js/app.js"></script>
	<?php endif; ?>
</head>
<body>
	<div id="agenda"><!-- js --></div>

	<script id="agenda-template" type="text/html">
		<table class="conferencer-agenda">
			<thead>
				<tr>
					<th></th>
					{{#tracks}}
						<th>{{name}}</th>
					{{/tracks}}
				</tr>
			</thead>
			<tbody>
				{{#timeslots}}
					<tr>
						<td>{{name}}</td>
						{{#sessions}}
							<td>
								<h2>{{title}}</h2>
								<h3>{{speaker}}</h3>
								<p>{{summary}}</p>
							</td>
						{{/sessions}}
					</tr>
				{{/timeslots}}
			</tbody>
		</table>
	</script>
</body>
</html>