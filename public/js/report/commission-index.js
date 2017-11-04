//Set Link day month week
$(".link-day").attr("href",DATA.link.day);
$(".link-week").attr("href",DATA.link.week);
$(".link-month").attr("href",DATA.link.month);
if ( DATA.opt == 1 ){
  $(".link-day").attr("disabled", "disabled");
} else if ( DATA.opt ==2 ) {
  $(".link-week").attr("disabled", "disabled");
} else {
  $(".link-month").attr("disabled", "disabled");
}
//Time range button
$('input[name="daterange"]').daterangepicker();
$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
  var link = 'commission?opt=' + DATA.opt + '&from_date=' + picker.startDate.format('YYYY-MM-DD');
  link += '&to_date=' + picker.endDate.format('YYYY-MM-DD');
  window.location.replace(link);
});