define([
	'jquery',
	'mustache'
], function(
	$,
	Mustache
) {
	var sessions = [
		{ start: 1444060800, end: 1444064400, title: "Code Rules", speaker: "Matt DeClaire", summary: lorem },
		{ start: 1444060800, end: 1444064400, title: "Subtlety", speaker: "Katie DeClaire", summary: lorem },
		{ start: 1444060800, end: 1444064400, title: "Super Chickens", speaker: "Ellie DeClaire", summary: lorem },
		{ start: 1444064400, end: 1444068000, title: "Architecture", speaker: "Matt DeClaire", summary: lorem },
		{ start: 1444064400, end: 1444068000, title: "Inference", speaker: "Katie DeClaire", summary: lorem },
		{ start: 1444064400, end: 1444068000, title: "Motivation", speaker: "Ellie DeClaire", summary: lorem },
		{ start: 1444068000, end: 1444071600, title: "TDD", speaker: "Matt DeClaire", summary: lorem },
		{ start: 1444068000, end: 1444071600, title: "Clarity", speaker: "Katie DeClaire", summary: lorem },
		{ start: 1444068000, end: 1444071600, title: "GTD", speaker: "Ellie DeClaire", summary: lorem }
	];

	var lorem = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

	var conference = {
		tracks: [
			{ name: "Engineering" },
			{ name: "Design" },
			{ name: "Management" }
		],
		timeslots: [
			{
				name: "9:00-10:00",
				sessions: [
					{ title: "Code Rules", speaker: "Matt DeClaire", summary: lorem },
					{ title: "Subtlety", speaker: "Katie DeClaire", summary: lorem },
					{ title: "Super Chickens", speaker: "Ellie DeClaire", summary: lorem }
				]
			},
			{
				name: "10:00-11:00",
				sessions: [
					{ title: "Architecture", speaker: "Matt DeClaire", summary: lorem },
					{ title: "Inference", speaker: "Katie DeClaire", summary: lorem },
					{ title: "Motivation", speaker: "Ellie DeClaire", summary: lorem }
				]
			},
			{
				name: "11:00-12:00",
				sessions: [
					{ title: "TDD", speaker: "Matt DeClaire", summary: lorem },
					{ title: "Clarity", speaker: "Katie DeClaire", summary: lorem },
					{ title: "GTD", speaker: "Ellie DeClaire", summary: lorem }
				]
			}
		]
	};

	$.each(sessions, function(ndx, session) {
		// var name = 
	});

	$(function() {
		var template = $('#agenda-template').html(),
			html = Mustache.render(template, conference);
		$('#agenda').html(html);
	});
});
