let map;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -6.9826852522070375, lng: 110.4091181567697 },
    zoom: 18,
  });
}