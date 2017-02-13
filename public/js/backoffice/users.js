$(function() {
	loadGrid();
    getPackages();
});

var grid_container = "#grid";
var pager_container = "#gridPager";

var currentUser = 0;

function getPackages() {
    $.ajax({
        url: '/api/getPackages',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
            var toReplace = "";
            var packages = response.rows;
            $.each(packages, function(key, val) {
                console.log(val);
                toReplace += "<option value='"+val.cell[0]+"'>"+val.cell[1]+"</option>";
            });
            $('#package_id').html(toReplace);
        }
    });
}

function loadGrid() {
	params = {};
    params.postData = {}
    params.postData.is_grid = true;

    params.url = "/api/getUsers";

    params.datatype = "json";
    params.mtype = 'Get';
    params.styleUI = 'Bootstrap';
    params.autowidth = true;
    params.height = 'auto';
    params.rownumbers = true;
    params.shrinkToFit = true;
    params.colNames = [
        'Actions',
        'Full name',
        'Username / Facebook ID',
        'Privilege',
        'Email',
        'Site Url'
    ];
    params.colModel = [
        {
            name: 'actions',
            index: 'actions',
            sortable: false,
            width: 60
        }, {
            name: 'full_name',
            index: 'full_name',
            align: 'center',
            width: 200
        }, {
            name: 'username',
            index: 'username',
            align: 'center',
            width: 200
        }, {
            name: 'privilege',
            index: 'privilege',
            align: 'center',
            width: 70
        }, {
            name: 'email',
            index: 'email',
            align: 'center',
            width: 200
        }, {
            name: 'site_url',
            index: 'site_url',
            align: 'center',
            width: 200
        }
    ];
    params.rowNum = 10;
    params.rowList = [10, 20, 30, 40, 50, 100];
    params.pager = pager_container;
    params.sortname = 'package_name';
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

function resetPassword(id) {
	currentUser = id;
    $('#resetPassModal').modal('show');
}

function doPasswordReset() {
    $.ajax({
        url: '/api/resetPartnerPassword',
        type: 'POST',
        dataType: 'JSON',
        data: {
            partner_id: currentUser,
            password: $('#reset_password').val(),
            password_confirmation: $('#reset_password_confirmation').val()
        },
        success: function(response) {
            if(response.success == 1) {
                closeAndClearResetPass();
            } else {
                alert("There was an error! Please try again!");
            }
        }
    });
}

function closeAndClearResetPass() {
    $('#resetPassModal').modal('hide');
    $('#reset_password').val('');
    $('#reset_password_confirmation').val('');
    currentUser = 0;    
}

function searchGrid() {
	var object = {};
	object.is_grid = true;

    jQuery(grid_container).jqGrid('setPostData', object);
    jQuery(grid_container).trigger("reloadGrid");
}

var client1 = new XMLHttpRequest();
function save() {
    var file = document.getElementById("avatar");
     
    /* Create a FormData instance */
    var formData = new FormData();
    
    /* Add the file */ 
    formData.append("avatar", file.files[0]);

    /* Add other data */
    formData.append("username", $('#username').val());
    formData.append("password", $('#password').val());
    formData.append("password_confirmation", $('#password_confirmation').val());
    formData.append("full_name", $('#full_name').val());
    formData.append("email", $('#email').val());
    formData.append("site_url", $('#site_url').val());
    formData.append("package_id", $('#package_id').val());


    client1.open("post", "/api/addPartnerAccount", true);
    //client.setRequestHeader("Content-Type", "multipart/form-data");
    client1.send(formData);  /* Send to server */ 
}


/* Check the response status */  
client1.onreadystatechange = function() {
    if (client1.readyState == 4 && client1.status == 200) {
        var response = JSON.parse(client1.response);

        if(response.success == 1) {
            closeAndClear();
            searchGrid();
        } else {
            alert(response.message);
        }

    }
}

function closeAndClear() {
	$('#addEditPartnerModal').modal('hide');

	$('#username').val("");
    $('#password').val("");
    $('#password_confirmation').val("");
    $('#full_name').val("");
    $('#email').val("");
    $('#site_url').val("");
    $('#package_id').val("");
	$('#avatar').val("");
}