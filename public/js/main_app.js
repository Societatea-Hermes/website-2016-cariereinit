var currentEvent = 0;


function alertNotLoggedIn() {
    alert("Intră în cont sau creează unul nou pentru a putea accesa toate informațiile.");
}

var eventTimeline = '<div class="cd-timeline-block">\
								<div class="cd-timeline-img cd-picture"></div>\
								<div class="cd-timeline-content">\
									<h2>{{title}}</h2>\
									{{description}}\
									<span class="cd-date">{{date}}</span>\
								</div>\
							</div>';


function getEventData(id) {
    $.ajax({
        url: '/api/getEventById',
        type: 'GET',
        dataType: 'JSON',
        data: {
            id: id
        },
        success: function (response) {
            currentEvent = id;
            $('#eventName').html(response.event.name);
            $('#eventDescription').html(response.event.description);

            var timeline = "";
            $.each(response.timeline, function (key, value) {
                var tmp = eventTimeline;
                tmp = tmp.replace('{{title}}', value.name);
                tmp = tmp.replace('{{description}}', value.description);
                tmp = tmp.replace('{{date}}', value.date_start + " - " + value.date_end);
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
        success: function (response) {
            if (response.success == 1) {
                alert("Inscrierea a fost realizata cu succes!");
                currentEvent = 0;
                $('#eventData').modal('hide');
            } else {
                alert("Error: " + response.message);
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

var offerTemplateNoCV = '\
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
                        <label for="avatar">Aplica direct pe site-ul companiei</label>\
                    </div>\
                </div>\
         </div>\
	</div>';

var specialRequirements = []

function getJobOffers(id) {
    $.ajax({
        url: '/api/getOffers',
        type: 'GET',
        dataType: 'JSON',
        data: {
            partner_id: id
        },
        success: function (response) {
            var offers = response.rows;
            var toReplace = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">' +
                '<input type="checkbox"  onclick="acceptGDPR()" id="accept" value="Politici"> Accept prelucrarea datelor personale de catre Societatea Hermes si Firmele Partenere, in vederea unei posibile recrutari.<br>' +
                '<input type="checkbox" onclick="showDetailsGdpr()" id="showGdpr">Vezi mai multe despre prelucrarea datelor cu caracter personal:' +
                '<div id="detailsGdpr" style="display: none">' +
                '<b>Acord privind Politica de Confidențialitate</b>' +'<br>'+
                'Acest formular cuprinde o informare cu privire la datele colectate de la dumneavoastră.' +'<br>'+
                ' În colectarea acestor date, conform legii, trebuie să vă furnizam informații despre noi,' +'<br>'+
                ' motivele pentru care colectăm datele și cum le vom utiliza, precum și despre drepturile' +'<br>'+
                ' pe care le aveți cu privire la datele dumneavoastră cu caracter personal. Prin acest' +'<br>'+
                ' formular vă solicităm să vă exprimați consimțământul pentru a putea utiliza datele' +'<br>'+
                ' dumneavoastră cu caracter personal, în scopurile specificate aici. Vă rugăm să completați' +'<br>'+
                ' acest formular doar dacă sunteți de acord să ne acordați acest consimțământ în vederea' +'<br>'+
                ' scopurilor specificate aici.' +'<br>'+'<br>'+
                '<b>Cine suntem?</b>' +
                '<br>'+
                'Denumirea societății care vă solicită consimțământul pentru utilizarea datelor dumneavoastră,' +'<br>'+
                ' în scopurile specificate în acest formular, este:' +'<br>'+
                'ASOCIAȚIA HERMES' +'<br>'+
                'str. Bogdan Petriceicu, nr.45, sala H4' +'<br>'+
                'Cluj-Napoca, judeţul Cluj, România' +'<br>'+
                '<br>'+
                '<b>Dorim să utilizăm următoarele date cu caracter personal:</b>' +
                '<br>' +
                'Nume și Prenume' +'<br>'+
                'Adresa de e-mail' +'<br>'+
                'Curriculum Vitae' +'<br>'+
                'Utilizarea datelor dumneavoastră' +'<br>'+
                '<br>'+
                'Datele dumneavoastră vor fi folosite exclusiv în scopul recrutării în cadrul evenimentului' +'<br>'+
                '"Cariere in IT". Dându-vă acordul, datele dumneavoastră pot fi transmise altor companii ' +'<br>'+
                'afiliate sau cu care se află în relații de parteneriat, dar numai în scopurile specificate' +'<br>'+
                'aici. Puteți oricând să vă retrageți consimțământul pentru utilizarea viitoar e, stocarea,' +'<br>'+
                'distribuirea sau dezvăluirea datelor dumneavoastră cu caracter personal. Cu toate acestea,' +'<br>'+
                'vă rugăm să rețineți că retragerea consimțământului dumneavoastră va produce efecte' +'<br>'+
                'doar pentru procesarea ulterioară a datelor dumneavoastră cu caracter personal și nu' +'<br>'+
                ' va afecta ' +
                'legalitatea procesării deja efectuate.' +'<br>'+
                '<b>Retragerea consimțământului</b>' +'<br>'+
                '<br>'+
                'Vă puteți retrage consimțământul oricând la adresa de email: ' +'<br>'+
                'contact@societatea-hermes.ro.' +'<br>'+
                '<br>'+
                '<b>Durata de păstrare a datelor</b>' +
                '<br>'+'<br>'+
                'Vom pastră datele dumneavoastră timp de 2 luni de la data furnizării lor către noi.'+'<br>'+
                '<b>Contact</b>' +'<br>'+
                '<br>'+
                'Dacă aveți întrebări, reclamații sau aveți nevoie de informații suplimentare despre ' +'<br>'+
                'această Politică de Confidențialitate, vă rugăm să ne contactați la adresa de email:' +'<br>'+
                ' contact@societatea-hermes.ro.'+'<br>'+
                '</p>' +
                '</div>' +
                '<br>'+

                '<div id="gdpr" style="display: none">';
            $('#companyName').html(response.partner);

            var converter = new showdown.Converter();

            $.each(offers, function (key, val) {
                if (specialRequirements.includes(val.cell[3]))
                    toReplace += offerTemplateNoCV
                else
                    toReplace += offerTemplate;

                toReplace = toReplace.replace("{{title}}", val.cell[1]);
                var description = val.cell[2];
                var descriptionFinal = converter.makeHtml(description);
                toReplace = toReplace.replace("{{description}}", descriptionFinal);
                toReplace = toReplace.replace(/{{id}}/g, val.cell[0]);
            });

            toReplace += '</div></div>';

            $('#offerBody').html(toReplace);
            $('#jobOffers').modal('show');
        }
    });
}

function acceptGDPR() {
    console.log("intra in functie")
    let x = document.getElementById("gdpr")
    let checkBox = document.getElementById("accept");
    if (checkBox.checked == true) {
        console.log("accept");
        x.style.display = "block";
    } else {
        console.log("not accept");
        x.style.display = "none";
    }
}

function showDetailsGdpr() {
    console.log("intra in functie")
    let x = document.getElementById("detailsGdpr")
    let checkBox = document.getElementById("showGdpr");
    if (checkBox.checked == true) {
        console.log("accept");
        x.style.display = "block";
    } else {
        console.log("not accept");
        x.style.display = "none";
    }
}

var client1 = new XMLHttpRequest();

function uploadCV(id) {
    var file = document.getElementById("cv_" + id);

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
client1.onreadystatechange = function () {
    if (client1.readyState == 4 && client1.status == 200) {
        var response = JSON.parse(client1.response);

        if (response.success == 1) {
            alert("CV-ul tau a fost trimis!");
        } else {
            alert(response.message);
        }

    }
}
