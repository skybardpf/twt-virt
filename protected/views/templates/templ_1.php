<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?= $page['title_window']; ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $this->asset_static; ?>/css/template1.css">
	<? if($kind == 'contacts'):?>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>
			function mail() {
				var url = '/sites/mail';
			    var id = this.id;
			    $.ajax({
			        type: "POST",
			        url: url,
			        data: {
			        	self_email: '<?= $page['email']; ?>',
			        	fio: $('#fio').val(),
			        	email: $('#email').val(),
			        	text: $('#text').val()
			        },
			        success: function(data){
			        	alert("Ваше сообщение успешно отправлено.");
			        }
			    });
			}
		    </script>
		<? if($page['map'] == 'yandex'):?>
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
			            hintContent: "<?= $page['address']; ?>"
			        });
			    	myMap.geoObjects.add(myPlacemark);
			    },
			    function (err) {
			        alert('Ошибка карты.');
			    });
			}
			</script>
		<? endif; ?>
		<? if($page['map'] == 'google'):?>
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
		    <script>
		    var url = 'http://maps.googleapis.com/maps/api/geocode/json?address=<?= $page['address']; ?>&sensor=true';
		    var id = this.id;
		    $.ajax({
		        type: "GET",
		        url: url,
		        data: {
		        },
		        success: function(data){
		        	var r = data['results'];
		            var map;
		            var service;
		            var infowindow;
		
		                var myLatlng = new google.maps.LatLng(r[0]['geometry']['location']['lat'], r[0]['geometry']['location']['lng']);
		                var myOptions = {
		                    zoom: 15,
		                    center: myLatlng,
		                    mapTypeId: google.maps.MapTypeId.ROADMAP
		                }
		                var map = new google.maps.Map(document.getElementById("map"), myOptions);
		                var marker = new google.maps.Marker({
		                    position: myLatlng,
		                    map: map,
		                    title:"<?= $page['address']; ?>" 
		                });
		        }
		    });
		    </script>
		<? endif; ?>
	<? endif; ?>
</head>
<body>
<div class="wrapper">
	<div class="wrapper-inner">
		<div class="header">
			<div class="inner-cont">
				<div class="logo">
					<a href="/">
						<img src="http://<?= $_SERVER['HTTP_HOST'].$page['logo']; ?>">
					</a>
				</div>
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
					<? if(($kind != 'contacts') && ($page['file'] != null)):?>
						<a href="/">
							<img src="http://<?= $_SERVER['HTTP_HOST'].$page['file']; ?>">
						</a>
					<? endif; ?>
				</div>
				<div class="content">
					<h1><?= $page['title_page']; ?></h1>
					<?= $page['content']; ?>
					<br /><br />
					<? if($kind == 'contacts'):?>
						<? if(($page['address'] != "")):?>
							<div id="map" style="width:400px; height:300px"></div>
						<? endif; ?>
						<br /><br />
						<form method="post" action="/sites/mail">
							<input id="fio" placeholder="ФИО" /><br />
							<input id="email" placeholder="email" /><br />
							<textarea id="text" placeholder="Введите текст сообщения здесь" style='height: 150px; width: 500px;'></textarea><br />
							<input type='button' onclick='mail();' value=' Отправить сообщение ' />
						</form>
					<? endif; ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="footer">
	<div class="inner-cont">
		<?php foreach ($page['files'] as $_file) : ?>
		<span><?= $_file['filename']; ?> </span><a href='<?= $_file['file']; ?>'>Скачать</a><br />
		<?php endforeach ?>
		Тут какая-то информация<br>
		Возможно, контакты и/или копирайт
	</div>
</div>
</body>
</html>