$('input[name="daterange"]').daterangepicker();
$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
    window.location.replace("{{ Request::url() }}?from_date="+picker.startDate.format('YYYY-MM-DD')+'&to_date='+picker.endDate.format('YYYY-MM-DD'));
});
$('.total-package').html(totalValue);