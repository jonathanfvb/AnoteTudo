/*
 * custom.js
 *
 * Place your code here that you need on all your pages.
 */

"use strict";

$(document).ready(function(){
	
	//===== Sidebar Search (Demo Only) =====//
	$('.sidebar-search').submit(function (e) {
		//e.preventDefault(); // Prevent form submitting (browser redirect)

		$('.sidebar-search-results').slideDown(200);
		return false;
	});

	$('.sidebar-search-results .close').click(function() {
		$('.sidebar-search-results').slideUp(200);
	});

	//===== .row .row-bg Toggler =====//
	$('.row-bg-toggle').click(function (e) {
		e.preventDefault(); // prevent redirect to #

		$('.row.row-bg').each(function () {
			$(this).slideToggle(200);
		});
	});

	//===== Sparklines =====//

	$("#sparkline-bar").sparkline('html', {
		type: 'bar',
		height: '35px',
		zeroAxis: false,
		barColor: App.getLayoutColorCode('red')
	});

	$("#sparkline-bar2").sparkline('html', {
		type: 'bar',
		height: '35px',
		zeroAxis: false,
		barColor: App.getLayoutColorCode('green')
	});
});