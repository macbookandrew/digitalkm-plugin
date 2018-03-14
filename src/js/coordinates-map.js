document.addEventListener("DOMContentLoaded", function (event) {
	"use strict";
	var i,
		geoJSONMaps = document.getElementsByClassName('geo-json-map');

	/** Loop through all maps */
	for (i = 0; i < geoJSONMaps.length; i += 1) {

		/** Get data */
		var thisMapLocationInfo = JSON.parse(geoJSONMaps[i].dataset.locationinfo),
			thisMap = L.map(geoJSONMaps[i], {
				scrollWheelZoom: false,
			}).setView([35.245134, -81.341194], 9),
			marker,
			markerGroup;

		/** Set up map */
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(thisMap);

		L.geoJSON(thisMapLocationInfo).addTo(thisMap);

		/** Zoom to fit all features */
		thisMap.fitBounds(L.geoJSON(thisMapLocationInfo).getBounds().pad(0.03));

	}

});
