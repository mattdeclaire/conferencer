<?php require_once __DIR__.'/../init.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Agenda</title>
	<?php if (DEV): ?>
		<script src="/js-dev/vendor/require.js" data-main="/js-dev/app"></script>
	<?php else: ?>
		<script src="/js/app.js"></script>
	<?php endif; ?>
</head>
<body>
	<div id="agenda"><!-- js --></div>
</body>
</html>