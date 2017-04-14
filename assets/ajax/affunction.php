<?php

   // TO CHANGE!
   require_once( "../../../../../wp-config.php" );

/**
 *  Content filter from form input
 *
 */

  if (strlen($_REQUEST['firedvalue']) > 0) {
    global $wpdb;
    $post_ids = array();
    $query1 = 'SELECT r.object_id FROM ' . $wpdb->prefix . 'terms t, ' . $wpdb->prefix . 'term_relationships r WHERE t.term_id = r.term_taxonomy_id AND t.name like "%' . $_REQUEST['firedvalue'] . '%"';
    $results = $wpdb->get_results($query1);
      foreach ($results as $key => $value) {
        $post_ids[] = $value->object_id;
      }
    $post_ids = array_unique($post_ids);
  }

  if (preg_match('/_/', $_REQUEST['sortvalue'])) {
    $sort = explode('_', $_REQUEST['sortvalue']);
    $orderby = $sort[0];
    $order   = $sort[1];
  }
    else {
    $orderby = 'title';
    $order   = 'ASC';
  }

  $args = array();
  $argType = array('post_type'      => 'vimeo-video');
  $argOrder = array('orderby'       => $orderby,
                    'order'         => $order);

  if (strlen($_REQUEST['categoryvalue']) > 0) {
      $tax_query = array('tax_query' => array(
                                array(
                                    'taxonomy' => 'vimeo-videos',
                                    'terms' => $_REQUEST['categoryvalue'],
                                    'field' => 'slug',
                               ),
                            )
                         );
        $args = array_merge($args, $tax_query);
  }

  // Basically the queries and merges are here to create
  // one array of posts
  $args = array_merge($args, $argType);
  $args = array_merge($args, $argOrder);

  $query2 = new WP_Query($args);
  $post_load = wp_list_pluck( $query2->posts, 'ID' );

  if (isset($post_ids) && count($post_ids) > 0) {
    $posts = array_intersect($post_load, $post_ids);
  }
   else {
    $posts = $post_load;
   }

  // And that one array of posts is $posts
  // It kinda sucks that it takes 3 queries to get the results,
  // but I have other client work and I need to let this sit so
  // as I can stew on the problem.

  if (count($posts) > 0) {
  $query = new WP_Query(array('post_type' => 'vimeo-video', 'post__in' => $posts, 'orderby' => 'post__in'));

  $result = '';
  // The Loop
  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      $id = get_the_id();
      $post = get_post($id);
      get_the_post_thumbnail();
      $custom = get_post_custom($id);
      $terms = get_terms( 'vimeo-videos' );


      $term_links = '<ul>';
      foreach ( $terms as $term ) {
          $term_links .= '<li>';
          $term_links .= '<a href="' . esc_url( get_term_link( $term ) ) . '" alt="'. esc_attr( sprintf( __(''), $term->name ) ) . '">' . $term->name . '</a>';
          $term_links .= '</li>';
      }
      $term_links .= '</ul>';

      $result .= '<article>
          <header>
              <a title="' . strtoupper(get_the_title()) . '" href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a>
              <h2><a href="' . get_the_permalink() . '" rel="bookmark">' . strtoupper(get_the_title()) . '</a></h2>
          </header>
          <div>
              <p>' . $post->post_excerpt . '</p>
              <div>
                  <div>
                      <p>' . get_the_date() . '</p>
                  </div>
                  <div>
                      <p>' . $custom['company'][0] . '</p>
                  </div>
                  <div>
                      <h3>Category:</h3>
                      <p>' . $term_links . '</p>
                      <div><a href="/search-test/">Back To Video Gallery</a></div>
                  </div>
              </div>
          </div>
          <footer></footer>
      </article>';

    }
   }
  }
    else {
          // echo $GLOBALS['query']->request;
          $result = 'No Results Found.';
  }

   echo $result;


