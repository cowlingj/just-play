$(document).ready(function() {
  $("span#range").html($("#slider").val());
});

$(document).on("change", "#slider", function() {
  $("span#range").html($(this).val());
});