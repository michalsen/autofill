
/**
 *  So here is some fun stuff.
 *  You may be wondering what the word "ghost" means
 *  as it is peppered about the code.
 *  It's the name of the client.
 */


jQuery(document).ready(
  function () {


    /**
     *  LocalStorage
     *  Clear / Set / Retrieve and populate form
     */
    jQuery('#filter_reset').click(function() {
        localStorage.removeItem('ghost_filter');
      });

    for (var key in localStorage) {
      if (key == 'ghost_filter') {
         var retrieveFilter = JSON.parse(localStorage.getItem('ghost_filter'));
           jQuery('#video_filter_text').val(retrieveFilter["ghost_fv"]);
           jQuery('#sort_filter').val(retrieveFilter["ghost_sort"]);
           jQuery('#category_filter').val(retrieveFilter["ghost_categoryvalue"]);
      }
    }
    // End LocalStorage





   /**
     *  onChange Form submit
     *  Submit values to ajax affunction.php
     */
    jQuery( "#ghost_filter" ).ready(function(e) {
      filterPost();
    });
    jQuery( "#ghost_filter" ).keydown(function(e) {
      dropDown();
      filterPost();
    });
    jQuery( "#ghost_filter" ).change(function(e) {
      filterPost();
    });
    // End onChange Form submit
  }
);

   /**
     *  Drop Down changes
     *  This does the autofill dropdown off the text field.
     */
  var dropDown = function() {
     var filtervalue = document.getElementById('video_filter_text').value;
     var sendData = jQuery.ajax({
               type: 'POST',
               url: '/wp-content/plugins/autofill/assets/ajax/dropdownfilter.php',
               data: {filtervalue},
                 success: function(resultData) {
                     jQuery('.dropdown_results').html('<datalist id="video_filter_autofill">'+resultData+'</div>');
                 }
             }); // end ajax call
  }

   /**
     *  This is the filtered content
     *  from what is typed and what is selected on the dropdowns.
     */
  var filterPost = function() {
      var firedvalue = document.getElementById('video_filter_text').value;
      var sortvalue = document.getElementById('sort_filter').value;
      var categoryvalue = document.getElementById('category_filter').value;

      filter = {'ghost_fv': firedvalue,
                'ghost_sort': sortvalue,
                'ghost_categoryvalue': categoryvalue };

      localStorage.setItem('ghost_filter', JSON.stringify(filter));
      var sendData = jQuery.ajax({
               type: 'POST',
               url: '/wp-content/plugins/autofill/assets/ajax/affunction.php',
               data: {firedvalue, sortvalue, categoryvalue},
                 success: function(resultData) {
                     jQuery('.video_search_results').html("<div id='message'>"+resultData+"</div>");
                 }
             }); // end ajax call
  }
