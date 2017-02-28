$(function() {
	loadGrid();
});

var grid_container = "#grid";
var pager_container = "#gridPager";

var converter = new showdown.Converter();


var currentOffer = 0;

function loadGrid() {
	params = {};
    params.postData = {}
    params.postData.is_grid = true;

    params.url = "/api/getOffers";

    params.datatype = "json";
    params.mtype = 'Get';
    params.styleUI = 'Bootstrap';
    params.autowidth = true;
    params.height = 'auto';
    params.rownumbers = true;
    params.shrinkToFit = true;
    params.colNames = [
        'Actions',
        'Title',
        'Description',
        'Posted by'
    ];
    params.colModel = [
        {
            name: 'actions',
            index: 'actions',
            sortable: false,
            width: 60
        }, {
            name: 'title',
            index: 'title',
            align: 'center',
            width: 200
        }, {
            name: 'description',
            index: 'description',
            align: 'center',
            width: 100,
            hidden: true
        }, {
            name: 'full_name',
            index: 'full_name',
            align: 'center',
            width: 100,
            hidden: true
        }
    ];
    params.rowNum = 10;
    params.rowList = [10, 20, 30, 40, 50, 100];
    params.pager = pager_container;
    params.sortname = 'title';
    params.sortorder = 'ASC';
    params.viewrecords = true;
    params.caption = "Offers";

    params.subGrid = true;

    params.subGridRowExpanded = function(subgridDivID, rowID) {
        onOfferSubGridRowExpanded(subgridDivID, rowID);
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

function onOfferSubGridRowExpanded(subgridDivID, rowID) {
    addOfferRegistrationSubgrid(subgridDivID, rowID);
}

function addOfferRegistrationSubgrid(subgridDivID, rowID) {
    var subgridTableID = subgridDivID + "_offer";
    jQuery("#" + subgridDivID).html('');
    jQuery("#" + subgridDivID).attr('style', 'margin: 4px;');
    jQuery("#" + subgridDivID).append("<div class='row' style='margin-right: 0px'><div class='col-md-12'><center><table id='" + subgridTableID + "'></table></center></div></div>");
    jQuery("#" + subgridTableID).jqGrid({
        url: '/api/getOfferApplications',
        caption: "Offer applications",
        datatype: "json",
        mtype: 'GET',
        styleUI: 'Bootstrap',
        autowidth: true,
        height: 'auto',
        rownumbers: true,
        shrinkToFit: true,
        postData: {
            id: rowID,
            is_grid: true,
            rows: 10000,
        },
        colNames: [
            'Actions',
            'Full name',
            'Email'
        ],
        colModel: [
            {
                name: 'actions',
                index: 'actions',
                width: 50
            }, {
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

function edit(id) {
	$.ajax({
		url: '/api/getOfferById',
		type: 'GET',
		dataType: 'JSON',
		data: {
			id: id
		},
		success: function(response) {
			currentOffer = response.id;
			$('#title').val(response.title);
			$('#description').val(response.description);
            changePreview();
            $('#addEditOfferModal').modal('show');
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
		url: '/api/addEditOffer',
		type: 'POST',
		dataType: 'JSON',
		data: {
			id: currentOffer,
			title: $('#title').val(),
			description: $('#description').val()
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
	$('#addEditOfferModal').modal('hide');
    currentOffer = 0;
    $('#title').val("");
    $('#description').val("");
    changePreview();
}

function download(id) {
    window.open("/api/downloadApplication/"+id);
}

function changePreview() {
    var text = $('#description').val();
    var textFinal = converter.makeHtml(text);

    $('#offerPreview').html(textFinal);
}
