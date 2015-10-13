define([
	'jquery',
	'mustache',
	'moment',
	'tpl!agenda'
], function(
	$,
	Mustache,
	moment,
	agendaTpl
) {
	var sessions = [
		{ start: 1444064400, end: 1444068000, track: "Engineering", title: "Architecture", speaker: "Matt DeClaire" },
		{ start: 1444064400, end: 1444068000, track: "Design", title: "Inference", speaker: "Katie DeClaire" },
		{ start: 1444064400, end: 1444068000, track: "Management", title: "Motivation", speaker: "Ellie DeClaire" },
		{ start: 1444060800, end: 1444064400, track: "Engineering", title: "Code Rules", speaker: "Matt DeClaire" },
		{ start: 1444060800, end: 1444064400, track: "Design", title: "Subtlety", speaker: "Katie DeClaire" },
		{ start: 1444060800, end: 1444064400, track: "Management", title: "Super Chickens", speaker: "Ellie DeClaire" },
		{ start: 1444068000, end: 1444071600, track: "Engineering", title: "TDD", speaker: "Matt DeClaire" },
		{ start: 1444068000, end: 1444071600, track: "Design", title: "Clarity", speaker: "Katie DeClaire" },
		{ start: 1444068000, end: 1444071600, track: "Management", title: "GTD", speaker: "Ellie DeClaire" }
	];

	// Sort timeslots so that the agenda wil be in the right order
	sessions.sort(function(a, b) {
		return a.start - b.start;
	});

	// Add human readable timeslots to sessions
	$.each(sessions, function(ndx, session) {
		var format = 'h:mm a',
			start = moment.unix(session.start).format(format),
			end = moment.unix(session.end).format(format);
		session.timeslot = start + ' - ' + end;
	});

	// Get a sorted and unique list of tracks.

	var tracks = $.map(sessions, function(session) {
		return session.track;
	});

	tracks.sort();

	tracks = $.unique(tracks);

	// Get a unique list of timeslots.

	var timeslots = $.map(sessions, function(session) {
		return session.timeslot;
	});

	timeslots = $.unique(timeslots);

	// Create agenda

	var agenda = {};

	$.each(sessions, function(ndx, session) {
		var timeslot = session.timeslot,
			track = session.track;
		agenda[timeslot] = agenda[timeslot] || {};
		agenda[timeslot][track] = agenda[timeslot][track] || [];
		agenda[timeslot][track].push(session);
	});

	// Create Mustache view model

	var agendaViewModel = {
		tracks: tracks,
		timeslots: []
	};

	$.each(agenda, function(timeslot, tracks) {
		var tracksViewModel = [];

		$.each(tracks, function(track, sessions) {
			tracksViewModel.push({
				name: track,
				sessions: sessions
			});
		});

		agendaViewModel.timeslots.push({
			name: timeslot,
			tracks: tracksViewModel
		});
	});

	// Output agenda

	$(function() {
		var html = Mustache.render(agendaTpl, agendaViewModel);
		$('#agenda').html(html);
	});
});
