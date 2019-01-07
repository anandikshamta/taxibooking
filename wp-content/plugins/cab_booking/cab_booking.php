<?php
/*
Plugin Name:CabBooking
Description: ~ Book Cab using this software
Version: 1.0
Author: Anand
Author URI: mailto:anand.webdeveloper@gmail.com
*/
if (!class_exists('CabBooking'))
{
  class CabBooking
  {
    public $_name;
    public $page_title;
    public $page_name;
    public $page_id;

    public function __construct()
    {
		$this->_name      = 'Cab Booking';
		$this->page_title = 'booking';
		$this->page_name  = $this->_name;
		$this->page_id    = '0';

		register_activation_hook(__FILE__, array($this, 'activate'));
		register_deactivation_hook(__FILE__, array($this, 'deactivate'));
		register_uninstall_hook(__FILE__, array($this, 'uninstall'));

		add_filter('parse_query', array($this, 'query_parser'));
		add_filter('the_posts', array($this, 'page_filter'));

		require( dirname( __FILE__ ) . '/functions.php' );
		require( dirname( __FILE__ ) . '/book_here/book_here.php' );
		require( dirname( __FILE__ ) . '/book_here/book_here_form.php' );
		require( dirname( __FILE__ ) . '/company_signup/register.php' );
        
		require( dirname( __FILE__ ) . '/dashboard/manage.php' );
		require( dirname( __FILE__ ) . '/dashboard/managemenu.php' );
		require( dirname( __FILE__ ) . '/dashboard/vehicle.php' );
		require( dirname( __FILE__ ) . '/dashboard/drivers.php' );
		require( dirname( __FILE__ ) . '/dashboard/pricing.php' );
		require( dirname( __FILE__ ) . '/dashboard/price_meta.php' );
		require( dirname( __FILE__ ) . '/dashboard/bookings.php' );
		
          
        
    }

    public function activate()
    {
      global $wpdb;      

      delete_option($this->_name.'_page_title');
      add_option($this->_name.'_page_title', $this->page_title, '', 'yes');

      delete_option($this->_name.'_page_name');
      add_option($this->_name.'_page_name', $this->page_name, '', 'yes');

      delete_option($this->_name.'_page_id');
      add_option($this->_name.'_page_id', $this->page_id, '', 'yes');

      $the_page = get_page_by_title($this->page_title);

      if (!$the_page)
      {
        // Create post object
        $_p = array();
        $_p['post_title']     = $this->page_title;
        $_p['post_content']   = "This text may be overridden by the plugin. You shouldn't edit it.";
        $_p['post_status']    = 'publish';
        $_p['post_type']      = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status']    = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $this->page_id = wp_insert_post($_p);
		
		$r = array();
        $r['post_title']     = "book_here";
        $r['post_content']   = "This text may be overridden by the plugin. You shouldn't edit it.";
        $r['post_status']    = 'publish';
        $r['post_type']      = 'page';
        $r['comment_status'] = 'closed';
        $r['ping_status']    = 'closed';
        $r['post_category'] = array(1); 
        wp_insert_post($r);
		
		$f = array();
        $f['post_title']     = "company_signup";
        $f['post_content']   = "This text may be overridden by the plugin. You shouldn't edit it.";
        $f['post_status']    = 'publish';
        $f['post_type']      = 'page';
        $f['comment_status'] = 'closed';
        $f['ping_status']    = 'closed';
        $f['post_category'] = array(1);
        wp_insert_post($f);
		
      }
      else
      {
        // the plugin may have been previously active and the page may just be trashed...
        $this->page_id = $the_page->ID;

        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $this->page_id = wp_update_post($the_page);
      }

      delete_option($this->_name.'_page_id');
      add_option($this->_name.'_page_id', $this->page_id);
    }

    public function deactivate()
    {
      $this->deletePage();
      $this->deleteOptions();
    }

    public function uninstall()
    {
      $this->deletePage(true);
      $this->deleteOptions();
    }

    public function query_parser($q)
    {
	  if(isset($q->query_vars['page_id']) AND (intval($q->query_vars['page_id']) == $this->page_id ))
      {
        $q->set($this->_name.'_page_is_called', true);
      }
      elseif(isset($q->query_vars['pagename']) AND (($q->query_vars['pagename'] == $this->page_name) OR ($_pos_found = strpos($q->query_vars['pagename'],$this->page_name.'/') === 0)))
      {
        $q->set($this->_name.'_page_is_called', true);
      }
      else
      {
        $q->set($this->_name.'_page_is_called', false);
      }
    }
	function PageNotFound()
	{
		$posts[0]->post_title = "<h1>404 Not Found</h1>";
        $posts[0]->post_content= "The page that you have requested could not be found."; 
		return $posts;
	}
    function page_filter($posts)
    {
     	global $wp_query;  
		if ( !is_admin() && ($wp_query->query_vars['pagename']=="book_here")):
			$obj=new BookHere();
			$posts[0]->post_title = "&nbsp;";
			$posts[0]->post_content= $obj->BookCab(); 
      	endif;
		if ( !is_admin() && ($wp_query->query_vars['pagename']=="company_signup")):
			$obj=new CompanySignup();
			$posts[0]->post_title = "&nbsp;";
			$posts[0]->post_content= $obj->Register(); 
      	endif;
		
		if ( !is_admin() && ($wp_query->query_vars['pagename']=="cabbooking")):
            if ( is_user_logged_in() ):
				$manage=new ManageDashboard();
				$posts[0]->post_title = "&nbsp;";
                $posts[0]->post_content= $manage->getMyDashboard();  
            else:
               $url=get_bloginfo('url');          
			   wp_redirect($url);exit;
            endif;    
      	endif;
      	return $posts;
    }

    private function deletePage($hard = false)
    {
      global $wpdb;

      $id = get_option($this->_name.'_page_id');
      if($id && $hard == true)
        wp_delete_post($id, true);
      elseif($id && $hard == false)
        wp_delete_post($id);
    }

    private function deleteOptions()
    {
      delete_option($this->_name.'_page_title');
      delete_option($this->_name.'_page_name');
      delete_option($this->_name.'_page_id');
    }
  }
}
$cabbooking = new CabBooking();
?>