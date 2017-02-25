$(function() {
	initDatePicker();
	loadGrid();
});

var grid_container = "#grid";
var pager_container = "#gridPager";

var currentEvent = 0;
var currentTimeline = 0;

function initDatePicker() {
	$('#date_start, #date_end, #timeline_date_start, #timeline_date_end').datetimepicker({
		format: 'YYYY-MM-DD HH:mm'
	});
}

function loadGrid() {
	params = {};
    params.postData = {}
    params.postData.is_grid = true;

    params.url = "/api/getEvents";

    params.datatype = "json";
    params.mtype = 'Get';
    params.styleUI = 'Bootstrap';
    params.autowidth = true;
    params.height = 'auto';
    params.rownumbers = true;
    params.shrinkToFit = true;
    params.colNames = [
    	'Actions',
        'Name',
        'Date start',
        'Date end',
        'Max participants'
    ];
    params.colModel = [
    	{
    		name: 'actions',
            index: 'actions',
            sortable: false,
            width: 60
    	}, {
            name: 'name',
            index: 'name',
            align: 'center',
            width: 200
        }, {
            name: 'date_start',
            index: 'date_start',
            align: 'center',
            width: 100
        }, {
            name: 'date_end',
            index: 'date_end',
            align: 'center',
            width: 100
        }, {
            name: 'max_participants',
            index: 'max_participants',
            align: 'center',
            width: 50
        }
    ];
    params.rowNum = 10;
    params.rowList = [10, 20, 30, 40, 50, 100];
    params.pager = pager_container;
    params.sortname = 'created_at';
    params.sortorder = 'ASC';
    params.viewrecords = true;
    params.caption = "Events";

    params.subGrid = true;

    params.subGridRowExpanded = function(subgridDivID, rowID) {
        onEventSubGridRowExpanded(subgridDivID, rowID);
    };

    jQuery(grid_container).jqGrid(params);

    jQuery(grid_container).jqGrid('navGrid', pager_container, {
        refresh: true,
        edit: false,
        add: false,
        del: false,
        search: false
    });
}

function onEventSubGridRowExpanded(subgridDivID, rowID) {
    addEventRegistrationSubgrid(subgridDivID, rowID);
    addEventTimelineSubgrid(subgridDivID, rowID);
}

function addEventRegistrationSubgrid(subgridDivID, rowID) {
	var subgridTableID = subgridDivID + "_registrations";
    // jQuery("#" + subgridDivID).html('');
    jQuery("#" + subgridDivID).attr('style', 'margin: 4px;');
    jQuery("#" + subgridDivID).append("<div class='row' style='margin-right: 0px'><div class='col-md-12'><center><table id='" + subgridTableID + "'></table></center></div></div>");
    jQuery("#" + subgridTableID).jqGrid({
        url: '/api/getEventRegistrations',
        caption: "Event registrations",
        datatype: "json",
        mtype: 'GET',
        styleUI: 'Bootstrap',
        autowidth: true,
        height: 'auto',
        rownumbers: true,
        shrinkToFit: true,
        postData: {
            event_id: rowID,
            rows: 10000,
        },
        colNames: [
            'Full name',
            'Email'
        ],
        colModel: [
            {
                name: 'full_name',
                index: 'full_name',
                width: 200
            }, {
                name: 'email',
                index: 'email',
                width: 200
            }
        ],
        viewrecords: true,
        rowNum: 10000
    });
}

function addEventTimelineSubgrid(subgridDivID, rowID) {
    var subgridTableID = subgridDivID + "_timelines";
    // jQuery("#" + subgridDivID).html('');
    jQuery("#" + subgridDivID).attr('style', 'margin: 4px;');
    jQuery("#" + subgridDivID).append("<div class='row' style='margin-right: 0px'><div class='col-md-12'><center><table id='" + subgridTableID + "'></table></center></div></div>");
    jQuery("#" + subgridTableID).jqGrid({
        url: '/api/getEventTimelines',
        caption: "Event timeline",
        datatype: "json",
        mtype: 'GET',
        styleUI: 'Bootstrap',
        autowidth: true,
        height: 'auto',
        rownumbers: true,
        shrinkToFit: true,
        postData: {
            event_id: rowID,
            is_grid: true,
            rows: 10000,
        },
        colNames: [
            'Actions',
            'Name',
            'Date start',
            'Date end'
        ],
        colModel: [
            {
                name: 'actions',
                index: 'actions',
                sortable: false,
                width: 60
            }, {
                name: 'name',
                index: 'name',
                align: 'center',
                width: 200
            }, {
                name: 'date_start',
                index: 'date_start',
                align: 'center',
                width: 100
            }, {
                name: 'date_end',
                index: 'date_end',
                align: 'center',
                width: 100
            }
        ],
        viewrecords: true,
        rowNum: 10000,
        sortname: 'date_start',
        sortorder: 'ASC'
    });
}

function edit(id) {
	$.ajax({
		url: '/api/getEventById',
		type: 'GET',
		dataType: 'JSON',
		data: {
			id: id
		},
		success: function(response) {
			currentEvent = response.event.id;
			$('#name').val(response.event.name);
			$('#description').val(response.event.description);
			$('#date_start').val(response.event.date_start);
			$('#date_end').val(response.event.date_end);
			$('#max_participants').val(response.event.max_participants);
			$('#addEditEventModal').modal('show');
		}
	});
}

function searchGrid() {
	var object = {};
	object.is_grid = true;

    jQuery(grid_container).jqGrid('setPostData', object);
    jQuery(grid_container).trigger("reloadGrid");
}

function save() {
	$.ajax({
		url: '/api/addEditEvent',
		type: 'POST',
		dataType: 'JSON',
		data: {
			id: currentEvent,
			name: $('#name').val(),
			description: $('#description').val(),
			date_start: $('#date_start').val(),
			date_end: $('#date_end').val(),
			max_participants: $('#max_participants').val()
		},
		success: function(response) {
			if(response.success == 1) {
				closeAndClear();

				searchGrid();
			} else {
				alert("There was an error! Please try again!");
			}
		}
	});
}

function closeAndClear() {
	$('#addEditEventModal').modal('hide');

	currentEvent = 0;
	$('#name').val("");
	$('#description').val("");
	$('#date_start').val("");
	$('#date_end').val("");
	$('#max_participants').val("");
}

function addEventTimeline(eventId) {
    currentEvent = eventId;
    $('#addEditEventTimeline').modal('show');
}

function saveEventTimeline() {
    $.ajax({
        url: '/api/addEditEventTimeline',
        type: 'POST',
        dataType: 'JSON',
        data: {
            timeline_id: currentTimeline,
            id_event: currentEvent,
            name: $('#timeline_name').val(),
            description: $('#timeline_description').val(),
            date_start: $('#timeline_date_start').val(),
            date_end: $('#timeline_date_end').val()
        },
        success: function(response) {
            if(response.success == 1) {
                closeAndClearEventTimeline();
                searchGrid();
            } else {
                alert("There was an error! Please try again!");
            }
        }
    });
}

function closeAndClearEventTimeline() {
    $('#addEditEventTimeline').modal('hide');

    currentEvent = 0;
    currentTimeline = 0;
    $('#timeline_name').val(""),
    $('#timeline_description').val("");
    $('#timeline_date_start').val("");
    $('#timeline_date_end').val("");
}

function editEventTimeline(timelineId) {
    currentTimeline = timelineId;

    $.ajax({
        url: '/api/getEventTimelineById',
        type: 'GET',
        dataType: 'JSON',
        data: {
            id: timelineId
        },
        success: function(response) {
            currentEvent = response.event_timeline.event_id;
            $('#timeline_name').val(response.event_timeline.name);
            $('#timeline_description').val(response.event_timeline.description);
            $('#timeline_date_start').val(response.event_timeline.date_start);
            $('#timeline_date_end').val(response.event_timeline.date_end);
            $('#addEditEventTimeline').modal('show');
        }
    });
}

function deleteEventTimeline(timelineId) {
    if(!confirm("Are you sure you want to delete this timeline item?")) {
        return;
    }

    $.ajax({
        url: '/api/deleteEventTimeline',
        type: 'POST',
        dataType: 'JSON',
        data: {
            id: timelineId
        },
        success: function(response) {
            if(response.success == 1) {
                searchGrid();
            } else {
                alert("There was an error! Please try again!");
            }
        }
    });
}
