<?php
/**
 * @package Posts_in_Page
 * @author Eric Amundson <eric@ivycat.com>
 * @copyright Copyright (c) 2017, IvyCat, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */ 

$format=get_post_format();
$tags=get_the_tags($post_id); 
if($tags[0]->name): $intoleft_main=$tags[0]->name; $intoleft_title=$tags[0]->name.'_title'; $intoleft_text=$tags[0]->name.'_text'; endif;    

if($format=="image"):   
    $post_id=get_the_ID();
    $imgurl= wp_get_attachment_url( get_post_thumbnail_id($post_id) );
    if($imgurl)$imgstyle='background: url('.$imgurl.')';
	$slug = get_post_field( 'post_name', $post_id );
?>
  
	<!-- Start Wellcome Area -->
  <div id="<?php echo $slug;?>" class="<?php echo $intoleft_main;?> area-padding" style="<?php echo $imgstyle;?>">
    <div class="well-bg">
      <div class="test-overly"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="<?php echo $slug;?>-text">
              <div class="well-text text-center">
                <h2><?php the_title(); ?></h2>
                <p>
                  <?php the_content(); ?>
                </p>                
				
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Wellcome Area -->
	
	
<?php
elseif($format=="aside"): 
	$post_id=get_the_ID();
    $imgurl= wp_get_attachment_url( get_post_thumbnail_id($post_id) );
	$slug = get_post_field( 'post_name', $post_id );
   ?>
   <div id="<?php echo $slug;?>" class="<?php echo $intoleft_main;?> area-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="section-headline text-center">
            <h2><?php the_title(); ?></h2>
          </div>
        </div>
      </div>
      <div class="row">
	    <?php 
			if($imgurl!=""):
				$cols_class="col-md-6 col-sm-6 col-xs-12";
		?>
			<!-- single-well start-->
			<div class="<?php echo $cols_class;?>">
			  <div class="well-left">
				<div class="single-well">
				  <a href="#">
									  <img src="<?php echo $imgurl;?>" alt="">
									</a>
				</div>
			  </div>
			</div>
		<?php
		else:
			$cols_class="col-md-12 col-sm-12 col-xs-12";
		endif;
		?>		
        <!-- single-well end-->
        <div class="<?php echo $cols_class;?>">
          <div class="well-middle">
            <div class="single-well">
              <?php the_content(); ?>
            </div>
          </div>
        </div>
        <!-- End col-->
		
      </div>
    </div>
  </div>
   <?php
else:    
     
endif;

?>
