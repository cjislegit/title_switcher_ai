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
            'function' : newTitles,    // value we'd like to pass
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
            let newData = cleanData(data);
            console.log(newData);
         }
      })
    }

    $j("#generate").click(generate);

   const cleanData = (data) => {
      //Var to hold new clean data
      let newData = [];

      console.log(data);

      //Removes all extra character from the response and makes it into an array.
      data = data.replace(/Answer: |\\r\\n|\\|\[|\]|\"|\'/g, "").split(',');

      //If school is not returned school short will be set to "Not Found"
      // data[1] = data[0] ? data[1] : "Not Found";

      //Goes through each element in the data array
      data.forEach((element, index) => {
         //If the element in the data array is null it is replace with "Not Found" if not it is cleaned up.
         if (element ===null) {
            newData.push("Not Found");
         } else {
            //All punctuation is removed
            newData.push(element.replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]|^\s/g, '')); 
         }
      })
      return newData;
   }
});

