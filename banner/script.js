loadPicture();

function loadPicture() {
  window.onload = function () {
    $.ajax({
      type: "GET",
      url: "src/getBannerData",
      dataType: "json",
      success: function (bannerList, status, xhr) {
        console.log(bannerList);

        var display = " ";
        var indicator = "";
        var banners = "";
        $.each(bannerList, function (index, value) {
          /* banners += 
           '<img src="' +
            value.bannerURL +
            '" width="500" height="500" alt="img' +
            value.id +
            '" />'; */

          if (index == 0) {
            indicator +=
              '  <li data-target="#showBanner" data-slide-to="0" class="active"></li>';
            banners +=
              '  <div class="carousel-item active">  <img class="d-block w-100" src="' +
              value.bannerURL +
              '" alt="img' +
              value.id +
              '">  <div class="carousel-caption d-none d-md-block"> <h5> Image '+ value.id +'</h5> </div></div>';
          } else {
            indicator += '<li data-target="#showBanner" data-slide-to="'+index+'"></li>';
            banners +=
              '<div class="carousel-item"><img class="d-block w-100" src="' +
              value.bannerURL +
              '" alt="img' +
              value.id +
              '">'+
              '<div class="carousel-caption d-none d-md-block">'+
              '<h5> Image '+ value.id +'</h5>'+
            '</div></div>';
          }
        });
        console.log(banners);
        display = 
          /*' <ol class="carousel-indicators">' +
          indicator +
          ' </ol>'+ */
          '<div class="carousel-inner">' +
          banners +
          '</div>'+ 
          '<a class="carousel-control-prev" href="#showBanner" role="button" data-slide="prev">'+ 
          '<span class="carousel-control-prev-icon" aria-hidden="true">'+ 
          '</span><span class="sr-only">Previous</span></a> '+
          '<a class="carousel-control-next" href="#showBanner" role="button" data-slide="next">  '+
          '<span class="carousel-control-next-icon" aria-hidden="true"></span> '+
          '<span class="sr-only">Next</span>  </a> ';
        // document.getElementById("displayBanner").innerHTML = banners;
        // $("#bannerImg").append(banners)
        //$("#indicator").append(indicator)
        $("#showBanner").append(display);
      },
      error: function (xhr) {
        console.log(xhr);
        console.log("ajaxx");
      },
    });
  };
}

function openAdd(){
  document.getElementById("add").style.display="block";
}

function addBanner(){
  var imageURL = $("#url").val()
  console.log(imageURL);
  $.ajax(
    {
      type: "POST",
      url: "src/addBannerData",
      data: {
          "imageURL": imageURL,
      },
      dataType: "json",
      success: function (data, status, xhr) {
        alert("Added successful")
        location.reload()
      },
      error: function (data, status, xhr) {
        alert(xhr)
      }
    }
  )
}

function openDelete(){
  document.getElementById("delete").style.display="block";
}

function deleteBanner(){
  var imageID = $("#imageID").val()
  console.log(imageID);
  $.ajax(
    {
      type: "DELETE",
      url: "src/deleteBannerData/" + imageID,
      dataType: "json",
      success: function(data, status, xhr){
        alert("Deleted ")
        location.reload()
      },
      error: function (data, status, xhr) {
          alert(xhr)
      }
    }
  )
}