<?php


$form = '<div class="panel panel-info">
          <div class="panel-heading">
              <h4>Video Vault</h4>
           </div>
           <div class="panel-body">
           <form id="ghost_filter" method="POST">

           <input type="text" name="search" list="video_filter_autofill" id="video_filter_text">
           <div class="dropdown_results"></div>


           <select name="sort_filter" id="sort_filter">
             <option value="none">Sort Results By</option>
             <option value="title_ASC">Title ASC</option>
             <option value="title_DESC">Title DESC</option>
             <option value="date_ASC">Date ASC</option>
             <option value="date_DESC">Date DESC</option>
           </select>

           <select name="categories" id="category_filter">

             ' . getOptions("Categories") . '
           </select>
           <input type="submit" value="Reset" id="filter_reset">
           </form>
           </div>
        </div>
        <div class="video_search_results"></div>';

