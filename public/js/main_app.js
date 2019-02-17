var currentEvent = 0;

var eventTimeline = '<div class="cd-timeline-block">\
								<div class="cd-timeline-img cd-picture"></div>\
								<div class="cd-timeline-content">\
									<h2>{{title}}</h2>\
									{{description}}\
									<span class="cd-date">{{date}}</span>\
								</div>\
							</div>';
function alertNotLoggedIn(){
    alert("Creează-ți un cont.");
}
function getEventData(id) {
	$.ajax({
		url: '/api/getEventById',
		type: 'GET',
		dataType: 'JSON',
		data: {
			id: id
		},
		success: function(response) {
			currentEvent = id;
			$('#eventName').html(response.event.name);
			$('#eventDescription').html(response.event.description);

			var timeline = "";
			$.each(response.timeline, function(key, value) {
				var tmp = eventTimeline;
				tmp = tmp.replace('{{title}}', value.name);
				tmp = tmp.replace('{{description}}', value.description);
				tmp = tmp.replace('{{date}}', value.date_start+" - "+value.date_end);
				timeline += tmp;
			});

			$('#cd-timeline').html(timeline);

			$('#eventData').modal('show');
		}
	});
}

function signup() {
	$.ajax({
		url: '/api/registerForEvent',
		type: 'POST',
		dataType: 'JSON',
		data: {
			id: currentEvent
		},
		success: function(response) {
			if(response.success == 1) {
				alert("Inscriere realizata cu succes!");
				currentEvent = 0;
				$('#eventData').modal('hide');
			} else {
				alert("Error: "+response.message);
			}
		}
	});
}

var offerTemplate = '\
	<div class="panel panel-default">\
		<div class="panel-heading" role="tab" id="headingOne">\
			<h4 class="panel-title">\
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{id}}" aria-controls="{{id}}">\
					{{title}}\
				</a>\
			</h4>\
		</div>\
		<div id="{{id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">\
			<div class="panel-body">\
				<div class="descriptionInside">\
					{{description}}\
				</div>\
				<hr />\
				<div class="form-group">\
						<label for="avatar">Incarca-ti CV-ul</label>\
						<input type="file" name="cv" id="cv_{{id}}" class="form-control" required />\
					</div>\
				<button class="btn btn-success" onclick="uploadCV({{id}})">Aplica</button>\
			</div>\
		</div>\
	</div>';

function getJobOffers(id) {
	$.ajax({
		url: '/api/getOffers',
		type: 'GET',
		dataType: 'JSON',
		data: {
			partner_id: id
		},
		success: function(response) {
			var offers = response.rows;
			var toReplace = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
			$('#companyName').html(response.partner);

			var converter = new showdown.Converter();

			$.each(offers, function(key, val) {
				toReplace += offerTemplate;
				toReplace = toReplace.replace("{{title}}", val.cell[1]);
				var description = val.cell[2];
				var descriptionFinal = converter.makeHtml(description);
				toReplace = toReplace.replace("{{description}}", descriptionFinal);
				toReplace = toReplace.replace(/{{id}}/g, val.cell[0]);
			});

			toReplace += '</div>';

			$('#offerBody').html(toReplace);
			$('#jobOffers').modal('show');
		}
	});
}

var client1 = new XMLHttpRequest();
function uploadCV(id) {
    var file = document.getElementById("cv_"+id);
     
    /* Create a FormData instance */
    var formData = new FormData();
    
    /* Add the file */ 
    formData.append("application", file.files[0]);
    formData.append("id", id);

    client1.open("post", "/api/applyForOffer", true);
    //client.setRequestHeader("Content-Type", "multipart/form-data");
    client1.send(formData);  /* Send to server */ 
}


/* Check the response status */  
client1.onreadystatechange = function() {
    if (client1.readyState == 4 && client1.status == 200) {
        var response = JSON.parse(client1.response);

        if(response.success == 1) {
            alert("CV-ul tau a fost trimis!");
        } else {
            alert(response.message);
        }

    }
}
