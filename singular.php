<?php/*
  * SINGULAR TEMPLATE for Bootstrap 4 Wordpress Parent Theme by Michael Ahlstrom
  *
*/
?>
<?php get_header(); ?>

<?php // the lOOP: https://codex.wordpress.org/The_Loop ?>
  <!-- Start the Loop. -->
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
     <div class="post">
       <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

       <!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->
       <small><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?></small>

       <!-- Display the Post's content in a div box. -->
       <div class="entry">
         <?php the_content(); ?>
       </div>

       <!-- Display a comma separated list of the Post's Categories. -->
       <p class="postmetadata"><?php _e( 'Posted in' ); ?> <?php the_category( ', ' ); ?></p>

     </div> <!-- closes the first div box -->

   <!-- Stop The Loop (but note the "else:" - see next line). -->
  <?php endwhile; else : ?>
   <!-- The very first "if" tested to see if there were any Posts to -->
   <!-- display.  This "else" part tells what do if there weren't any. -->
   <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

<!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php wp_footer(); ?>
