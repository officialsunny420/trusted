$(document).ready(function(){

        $thing = $('#demo').book({
            onPageChange:updateProgress,
            speed:200}
        ).validate();


        /* IE doesn't have a trunc function */
        if (!Math.trunc) {
            Math.trunc = function (v) {
                return v < 0 ? Math.ceil(v) : Math.floor(v);
            };
        }


        /* Update progress bar whenever the page changes */
        function updateProgress(prevPageIndex, currentPageIndex, pageCount, pageName){
            t = (currentPageIndex / (pageCount-1)) * 100;
            $('.progress-bar').attr('aria-valuenow', t);
            $('.progress-bar').css('width', t+'%');
            //$('.progress span').text('Completed: '+Math.trunc(t)+'%');
            $('.progress-value').text(Math.trunc(t)+'%');

            console.log(pageName);

        }

        /* form's submit button */
        $('#sendForm').on('click', function(e){
            e.preventDefault();

            if ($('#demo').valid()){
                // do ajax thingy here
                alert('Your data was sent.');
            }
        });



    });