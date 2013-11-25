<?php
use application\modules\domain\models as M;

/**
 * @var DisplayController $this
 * @var M\DomainPage $page
 * @var M\Domain $domain
 * @var M\DomainPage[] $menu
 */
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $page->window_title; ?></title>
    <link rel="stylesheet" type="text/css" href="<?= $this->asset_static . '/css/template2.css'; ?>">
    <? if ($page->kind === M\DomainPage::KIND_CONTACTS): ?>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <? if ($page->map === 'yandex'): ?>
        <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=RU" type="text/javascript"></script>
        <script type="text/javascript">
            var myMap;
            ymaps.ready(init);

            function init() {
                var myGeocoder = ymaps.geocode('<?= CHtml::encode($page->adress); ?>');
                myGeocoder.then(
                    function (res) {
                        myMap = new ymaps.Map('map', {
                            center: res.geoObjects.get(0).geometry.getCoordinates(),
                            zoom: 15
                        });
                        myPlacemark = new ymaps.Placemark(res.geoObjects.get(0).geometry.getCoordinates(), {
                            balloonContentHeader: "",
                            balloonContentBody: "",
                            balloonContentFooter: "",
                            hintContent: "<?= CHtml::encode($page->adress); ?>"
                        });
                        myMap.geoObjects.add(myPlacemark);
                    },
                    function (err) {
                        alert('Ошибка карты.');
                    });
            }
        </script>
    <? endif; ?>
    <? if ($page->map === 'google'): ?>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
        <script>
            var url = 'http://maps.googleapis.com/maps/api/geocode/json?address=<?= CHtml::encode($page->adress); ?>&sensor=true';
            var id = this.id;
            $.ajax({
                type: "GET",
                url: url,
                data: {
                },
                success: function (data) {
//                    console.log(data);
                    var r = data['results'];
//                    var map;
//                    var service;
//                    var infowindow;


//                    console.log(r[0]['geometry']['location']['lng']);

                    var myLatlng = new google.maps.LatLng(r[0]['geometry']['location']['lat'], r[0]['geometry']['location']['lng']);
                    var myOptions = {
                        zoom: 15,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById("map"), myOptions);
//                    console.log(map);
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: "<?= CHtml::encode($page->adress); ?>"
                    });
//                    console.log(marker);
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
                <?php
                if (!empty($page->logo)) {
                    $dir = Yii::getPathOfAlias('uploadDir') . DIRECTORY_SEPARATOR . 'site_page' . DIRECTORY_SEPARATOR . 'logos';
                    if (file_exists($dir . DIRECTORY_SEPARATOR . $page->logo)) {
                        ?>
                        <div class="logo">
                            <a href="/">
                                <img width="350" height="50"
                                     src="http://<?= $_SERVER['HTTP_HOST'] . '/upload/site_page/logos/' . $page['logo']; ?>">
                            </a>
                        </div>
                    <?php
                    }
                }

                $url = 'http://' . $domain->domain . '.' . $_SERVER['HTTP_HOST'] . '/';
                ?>
                <div class="menu">
                    <ul>
                        <?php
                        $menus = array();
                        foreach ($menu as $item) {
                            $menus[] = CHtml::link(Yii::t('app', M\DomainPage::kindToString($item->kind)), $url . $item->kind);
                        }
                        echo implode(' | ', $menus);
                        ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="inner-cont">
            <div class="main-content">
                <div class="visual">
                    <?php
                    //                    if(($page->kind !== M\DomainPage::KIND_CONTACTS) && (!empty($page->banner))){
                    //                        $dir = Yii::getPathOfAlias('uploadDir'). DIRECTORY_SEPARATOR . 'site_page' .DIRECTORY_SEPARATOR . 'banners';
                    //                        if (file_exists($dir.DIRECTORY_SEPARATOR.$page->banner)){
                    //                            echo '<a href="http://'.$_SERVER['HTTP_HOST'].'/upload/site_page/banners/'.$page->banner.'">';
                    //                            echo 'Banner';
                    //                            echo '</a>';
                    //                        }
                    //					}
                    ?>
                </div>
                <div class="content">
                    <h1><?= $page->page_title; ?></h1>
                    <?php if(($page->kind == M\DomainPage::KIND_CONTACTS) && (!empty($page->adress))): ?>
                		<div id="map" style="width:400px; height:300px"></div>
                	<?php endif; ?>
                    <?= $page->content; ?>
                    <br/><br/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="inner-cont">
        <?php
        if (($page->kind !== M\DomainPage::KIND_CONTACTS) && (!empty($page->banner))) {
            $dir = Yii::getPathOfAlias('uploadDir') . DIRECTORY_SEPARATOR . 'site_page' . DIRECTORY_SEPARATOR . 'banners';
            if (file_exists($dir . DIRECTORY_SEPARATOR . $page->banner)) {
                echo '<a href="http://' . $_SERVER['HTTP_HOST'] . '/upload/site_page/banners/' . $page->banner . '">';
                echo 'Скачать баннер';
                echo '</a>';
            }
        }
        ?>
    </div>
</div>
</body>
</html>