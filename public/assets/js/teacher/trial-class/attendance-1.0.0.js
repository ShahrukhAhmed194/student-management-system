$(document).ready(function() {
    
    function updateAttendanceStatus() {
        var $attendanceBox = $(this).closest('.attendanceBox');
        var $joinedCheckbox = $attendanceBox.find('.joined');
        
        if ($(this).is(':checked')) {
            $joinedCheckbox.prop('checked', false).prop('disabled', true);
        } else {
            $joinedCheckbox.prop('disabled', false);
        }
    }

    $('.present').each(function() {
        updateAttendanceStatus.call(this);
    });

    $('.present').on('change', updateAttendanceStatus);
});