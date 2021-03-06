<?php
$row = $db->get_row("SELECT * FROM tb_tempat WHERE id_tempat='$_GET[ID]'");
?>
<div class="page-header">
    <h1><?= $row->nama_tempat ?></h1>
</div>
<div class="row">
    <div class="col-md-6">
        <p>Lokasi: <?= $row->lokasi ?></p>
        <div>
            <?= $row->keterangan ?>
        </div>
        <div>
            <div class="review_container" style="width: 100%;border:2px solid;border-radius: 8px;">
                <div class="card border-secondary" style="margin: 12px;">
                    <div class="card-header" style="border-bottom: 1px solid;">
                        <div style="display: flex;justify-content:flex-start;">
                            <img width="32px" height="32px" src="assets/account-circle-fill.png" alt="">
                            <p style="border: 2px; align-self:center; margin:0; margin-left:4px">Dimas Seto</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Makanan mantap ,tempat cakep</p>
                    </div>
                </div>
                <div class="input-group mb-3" style="margin: 12px;">
                    <input type="text" class="form-control" placeholder="masukan komentar disini" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary btn-dark" type="button" id="button-addon2" style="margin-right: 24px;" data-bs-toggle="modal" data-bs-target="#poplogin">Post</button>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div id="map" style="height: 500px;"></div>
        <h3>Galeri</h3>
        <div class="row">
            <?php
            $rows = $db->get_results("SELECT * FROM tb_galeri WHERE id_tempat='$_GET[ID]'");
            foreach ($rows as $r) : ?>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <!-- <a class="" href="#" data-image-id="" data-bs-toggle="modal" data-title="<?= $r->nama_galeri ?>" data-caption="<?= strip_tags($r->ket_galeri) ?>" data-image="assets/images/galeri/<?= $r->gambar ?>" data-bs-target="#image-gallery">
                    <img src="assets/images/galeri/small_<?= $r->gambar ?>" title="<?= $r->nama_galeri ?>" class="img-thumbnail mb-4"/>
                </a>  -->
                    <a class="thumbnail" href="#" data-image-id="" data-bs-toggle="modal" data-title="<?= $r->nama_galeri ?>" data-caption="<?= strip_tags($r->ket_galeri) ?>" data-image="assets/images/galeri/<?= $r->gambar ?>" data-bs-target="#image-gallery">
                        <img src="assets/images/galeri/small_<?= $r->gambar ?>" title="<?= $r->nama_galeri ?>" class="img-thumbnail mb-4" />
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>


<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="image-gallery-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-fluid" src="">
                <div class="text-justify" id="image-gallery-caption">
                    This text will be overwritten by jQuery
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="show-next-image" class="btn btn-primary">Next</button>
                <button type="button" class="btn btn-primary" id="show-previous-image">Previous</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="poplogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        untuk dapat mengirim komentar anda harus melakukan login
      </div>
      <div class="modal-footer">
      <a href="?m=login" style="text-decoration: none;color:azure"><button type="button" class="btn btn-primary">Login</button></a>
      </div>
    </div>
  </div>
</div>

<script>
    var origin_pos = {
        lat: default_lat,
        lng: default_lng
    };
    var dst_pos = {
        lat: <?= $row->lat ?>,
        lng: <?= $row->lng ?>
    };
    var errorRoute = false;
    var map_detail;
    var dragged = false;
    var directionsDisplay;
    var routeDisplayed = 0;

    //menampilkan map detail
    function tampilDetail() {


        map_detail = new google.maps.Map(document.getElementById('map'), {
            zoom: default_zoom,
            center: dst_pos
        });

        directionsDisplay = new google.maps.DirectionsRenderer({
            map: map_detail
        });

        addMarker(dst_pos, map_detail, '<?= $row->nama_tempat ?>');

        infoWindow = new google.maps.InfoWindow;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };


                origin_pos = pos;

                infoWindow.setPosition(pos);
                infoWindow.setContent('Lokasi anda');
                infoWindow.open(map_detail);
                map_detail.setCenter(pos);
            }, function() {
                handleLocationError(true, infoWindow, map_detail.getCenter());
            });
        } else {
            handleLocationError(false, infoWindow, map_detail.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    //menampilkan rute lokasi
    function showRoute() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        directionsDisplay.setMap(map_detail);
        calculateAndDisplayRoute(directionsService, directionsDisplay);
        console.log('Route displayed ' + ++routeDisplayed);
    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        directionsService.route({
            origin: origin_pos,
            destination: dst_pos,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }

    $(function() {
        tampilDetail();
    })

    $(document).ready(function() {

        loadGallery(true, 'a.thumbnail');

        //This function disables buttons when needed
        function disableButtons(counter_max, counter_current) {
            $('#show-previous-image, #show-next-image').show();
            if (counter_max == counter_current) {
                $('#show-next-image').hide();
            } else if (counter_current == 1) {
                $('#show-previous-image').hide();
            }
        }

        /**
         *
         * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
         * @param setClickAttr  Sets the attribute for the click handler.
         */

        function loadGallery(setIDs, setClickAttr) {
            var current_image,
                selector,
                counter = 0;

            $('#show-next-image, #show-previous-image').click(function() {
                if ($(this).attr('id') == 'show-previous-image') {
                    current_image--;
                } else {
                    current_image++;
                }

                selector = $('[data-image-id="' + current_image + '"]');
                updateGallery(selector);
            });

            function updateGallery(selector) {
                var $sel = selector;
                current_image = $sel.data('image-id');
                $('#image-gallery-caption').text($sel.data('caption'));
                $('#image-gallery-title').text($sel.data('title'));
                $('#image-gallery-image').attr('src', $sel.data('image'));
                disableButtons(counter, $sel.data('image-id'));
            }

            if (setIDs == true) {
                $('[data-image-id]').each(function() {
                    counter++;
                    $(this).attr('data-image-id', counter);
                });
            }
            $(setClickAttr).on('click', function() {
                updateGallery($(this));
            });
        }
    });
</script>