var noti = ''; 
const id = [];
const event_name = [];
const time = [];
const date = [];

function loadEvents(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'slim/events', true);
  
    xhr.onload = function(){
      if(this.status == 200){
        var events = JSON.parse(this.responseText);
        
        var output = '';
        output = '<tr>' +
            '<th>ID</th>' +
            '<th>Event</th>' +
            '<th>Time</th>' +
            '<th>Date</th>' +
            '<th>Notify</th>' +
            '<th>Delete</th>' +
            '</tr>';
        
        for(var i in events){
            date[i] = events[i].date;
            event_name[i] = events[i].event_name;
            time[i] = events[i].time;
            id[i] = events[i].id;

          output += '<tr>' +
            '<td>' + events[i].id +'</td>' +
            '<td>' + events[i].event_name +'</td>' +
            '<td>' + events[i].time +'</td>' +
            '<td>' + events[i].date +'</td>' +
            '<td><button type="button" class="btn btn-primary" onclick="myNotify(' + i + ')">Notify</button></td>' +
            '<td><button type="button" class="btn btn-warning" onclick="myDelete(' + i + ')">Delete</button></td>' +
            '</tr>';
        }
  
        document.getElementById('tableGET').innerHTML = output;
      }
    }
  
    xhr.send();
}

postForm.onsubmit = async (e) => {
    e.preventDefault();

    let response = await fetch('slim/index.php/addEvent', {
      method: 'POST',
      body: new FormData(postForm)
    });

    let result = await response.json();

    alert('Event added');
    loadEvents();
};

deleteForm.onsubmit = async (e) => {
    e.preventDefault();

    let response = await fetch('slim/index.php/deleteEvent', {
      method: 'POST',
      body: new FormData(deleteForm)
    });

    let result = await response.json();

    alert('Event deleted');
    loadEvents();
};

var box = document.getElementById('box');
    var down = false;
    function toggleNotifi() { 
        if (down) {
            box.style.height = '0px';
            box.style.opacity = 0;
            down = false;
        } else {
            box.style.height = '1000px';
            box.style.opacity = 1;
            down = true;
        }
}

function myNotify(i){
          noti += '<br><div class="text" style="border: 1px solid black; width: 100%; margin: 0">' +
                  '<h9>' + date[i] + '  |  ' + time[i] + '  |  ' + event_name[i] + '</h9>' +
              '</div>';
      
      document.getElementById("NotifyT").innerHTML = noti;
}

function myDelete(i){
    url = "slim/index.php/deleteEvent/" + id[i] +"";
    var xhr = new XMLHttpRequest();
    xhr.open('DELETE', url, true);

    xhr.send();
    alert("Event on '" + date[i] + "' called '" + event_name[i] + "' at '" + time[i] +" hrs' is deleted");
    loadEvents();
}
