$(document).ready(function () {
  // hilangkan button-search
  $("#button-search").hide();

  // event ketika keyword ditulis
  $("#input-search").on("keyup", function () {
    $(".loader").show();

    //menggunakan load
    // $('#table-container').load("ajax/mahasiswa.php?keywords=" + $('#inputSearch').val()); // use #inputSearch here

    //menggunakan get()
    $.get("ajax/mahasiswa.php?keyword=" + $("#input-search").val(), function (data) {
      $("#table-container").html(data);
      $(".loader").hide();
    });
  });
});
