document.addEventListener("DOMContentLoaded", function (event) {
	"use strict";
	var i,
		maps = document.getElementsByClassName('coordinates-map');

	/** Loop through all maps */
	for (i = 0; i < maps.length; i += 1) {

		/** Get data */
		var thisMapLocationInfo = JSON.parse(maps[i].dataset.locationinfo),
			thisMap = L.map(maps[i], {
				scrollWheelZoom: false,
			}).setView([thisMapLocationInfo.lat, thisMapLocationInfo.lng], 11),
			marker,
			markerGroup;

		/** Set up map */
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(thisMap);

		/** Handle points vs. circles */
		if (thisMapLocationInfo.precision === 'radius') {
			marker = L.circle([thisMapLocationInfo.lat, thisMapLocationInfo.lng], {
				title: thisMapLocationInfo.address,
				radius: thisMapLocationInfo.radius * 1609.344,
			}).addTo(thisMap);
		} else {
			marker = L.marker([thisMapLocationInfo.lat, thisMapLocationInfo.lng], {
				title: thisMapLocationInfo.address,
			}).addTo(thisMap);
		}

		/** Add popup */
		if (typeof marker !== 'undefined') {
			marker.bindPopup(thisMapLocationInfo.address).openPopup();
		}

		/** Zoom to fit circles */
		if (thisMapLocationInfo.precision === 'radius') {
			thisMap.fitBounds(marker.getBounds().pad(0.03));
		}

	}
});
