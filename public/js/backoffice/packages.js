$(function() {
	loadGrid();
});

var grid_container = "#grid";
var pager_container = "#gridPager";

var currentPackage = 0;

function loadGrid() {
	params = {};
    params.postData = {}
    params.postData.is_grid = true;

    params.url = "/api/getPackages";

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
        'Logo size'
    ];
    params.colModel = [
        {
            name: 'actions',
            index: 'actions',
            sortable: false,
            width: 60
        }, {
            name: 'package_name',
            index: 'package_name',
            align: 'center',
            width: 200
        }, {
            name: 'logo_size',
            index: 'logo_size',
            align: 'center',
            width: 100
        }
    ];
    params.rowNum = 10;
    params.rowList = [10, 20, 30, 40, 50, 100];
    params.pager = pager_container;
    params.sortname = 'full_name';
    params.sortorder = 'ASC';
    params.viewrecords = true;
    params.caption = "Users";

    jQuery(grid_container).jqGrid(params);

    jQuery(grid_container).jqGrid('navGrid', pager_container, {
        refresh: true,
        edit: false,
        add: false,
        del: false,
        search: false
    });
}

function edit(id) {
	$.ajax({
		url: '/api/getPackageById',
		type: 'GET',
		dataType: 'JSON',
		data: {
			id: id
		},
		success: function(response) {
			currentPackage = response.id;
			$('#package_name').val(response.package_name);
			$('#logo_size').val(response.logo_size);
			$('#addEditPackageModal').modal('show');
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
		url: '/api/addEditPackage',
		type: 'POST',
		dataType: 'JSON',
		data: {
			id: currentPackage,
			package_name: $('#package_name').val(),
			logo_size: $('#logo_size').val()
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
	$('#addEditPackageModal').modal('hide');

	currentPackage = 0;
	$('#package_name').val("");
	$('#logo_size').val("");
}