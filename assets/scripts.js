var $j = jQuery.noConflict();

$j(document).ready(function() {

    const submit = () => {
        let newTitles = [];
        let tempTitles = $j('.newTitles');
        delete tempTitles.length;
        delete tempTitles.prevObject;
        Object.values(tempTitles).forEach(element => {
           newTitles.push([element.id, element.value]);
        });

        let data = {
            'type'     : 'POST',
            'action'   : 'update_table', // the name of your PHP function!
            'function' : newTitles,    // a random value we'd like to pass
            };
           
         jQuery.post(ajaxurl, data, function(response) {
            jQuery("#receiving_div_id").html(response);
         });
    }

    $j("#submit").click(submit);

    const generate = () => {
      let industry = $j('#industry').val();
      let city = $j('#city').val();
      let state = $j('#state').val();
      
      $j.ajax({
         type: 'POST',
         url: ajaxurl,
         data: {
            'action': 'generate_tag',
            'industry': industry,
            'city': city,
            'state': state
         },
         success:function(data) {
            console.log(data);
         }
      })
    }

    $j("#generate").click(generate);
});

