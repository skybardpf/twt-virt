<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?= $page['title_window']; ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $this->asset_static; ?>/css/template2.css">
	<? if($kind == 'contacts'):?>
		<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=RU" type="text/javascript"></script>
		<script type="text/javascript">
		var myMap;
		ymaps.ready(init);
		
		function init () {
			var myGeocoder = ymaps.geocode('<?= $page['address']; ?>');
			myGeocoder.then(
		    function (res) {
		    	myMap = new ymaps.Map('map', {
			        center:res.geoObjects.get(0).geometry.getCoordinates(),
			        zoom:15
			    });
		    	myPlacemark = new ymaps.Placemark(res.geoObjects.get(0).geometry.getCoordinates(), {
		            balloonContentHeader: "",
		            balloonContentBody: "",
		            balloonContentFooter: "",
		            hintContent: ""
		        });
		    	myMap.geoObjects.add(myPlacemark);
		    	myMap.hint.show(myMap.getCenter(), "<?= $page['address']; ?>", {
		    	    showTimeout: 1500
		    	});
		    },
		    function (err) {
		        alert('Ошибка карты.');
		    });
		}
		</script>		
	<? endif; ?>
</head>
<body>
<div class="wrapper">
	<div class="wrapper-inner">
		<div class="header">
			<div class="over-head"></div>
			<div class="inner-cont">
			<? if(($kind != 'contacts') && ($page['file'] != null)):?>
				<div class="logo">
					<a href="/">
						<img src="http://<?= $_SERVER['HTTP_HOST'].$page['file']; ?>">
					</a>
				</div>
			<? endif; ?>
				<div class="menu">
					<ul>
						<?php foreach ($menu as $_menu_item) : ?>
						<li>
							<a href="<?= $_menu_item['page']; ?>"><?= $_menu_item['text']; ?></a>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="inner-cont">
			<div class="main-content">
				<div class="visual">
					
				</div>
				<div class="content">
					<?= $page['content']; ?>
					<br /><br />
					<? if($kind == 'contacts'):?>
						<div id="map" style="width:400px; height:300px"></div>
					<? endif; ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="footer">
	<div class="inner-cont">
		<? if($kind == 'main'):?>
			<?php foreach ($page['files'] as $_file) : ?>
			<a href='<?= $_file['file']; ?>'><?= $_file['file']; ?></a><br />
			<?php endforeach ?>
		<? endif; ?>
		Тут какая-то информация<br>
		Возможно, контакты и/или копирайт
	</div>
</div>
</body>
</html>