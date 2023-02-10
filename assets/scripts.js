var $j = jQuery.noConflict();

$j(document).ready(function() {

    let submit = () => {
        let newTitles = [];
        let tempTitles = $j('.newTitles');
        delete tempTitles.length;
        delete tempTitles.prevObject;
        Object.values(tempTitles).forEach(element => {
           newTitles.push([element.id, element.value]);
        });
        console.log(newTitles);

        var data = {
            'type'     : 'POST',
            'action'   : 'update_table', // the name of your PHP function!
            'function' : newTitles,    // a random value we'd like to pass
            'fileid'   : '7'              // another random value we'd like to pass
            };
           
         jQuery.post(ajaxurl, data, function(response) {
            jQuery("#receiving_div_id").html(response);
         });
    }

    $j("#submit").click(submit);

});

