$('input[name="daterange"]').daterangepicker();
$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
    window.location.replace("{{ Request::url() }}?type={{$temp->type}}&opt=4&from_date="+picker.startDate.format('YYYY-MM-DD')+'&to_date='+picker.endDate.format('YYYY-MM-DD'));
});
$('.total-package').html(totalValue);
var from_date = getFormatDate(data.date_custom.from_date);
var to_date = getFormatDate(data.date_custom.to_date);
$('input[name="daterange"]').data('daterangepicker').setStartDate(from_date);
$('input[name="daterange"]').data('daterangepicker').setEndDate(to_date);
function getFormatDate(date){
    date = new Date(date);
    return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
}