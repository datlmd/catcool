<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Posts extends MY_Controller {

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("blog/PostManager");
		$this->theme->theme('admin')
			->title('Admin Panel')
			->add_partial('header')
			->add_partial('footer')
			->add_partial('sidebar');
    }

	public function index()
	{
		$this->load->helper('url');

		$this->theme->load('post_index');
        //$this->parser->parse('post_index');
	}

	public function install()
	{
//		// Load Doctrine library
//		$this->load->library('doctrine');
//
//		$this->doctrine->tool->createSchema(array(
//			$this->doctrine->em->getClassMetadata('blog\models\Post')));
			$this->PostManager->install();
		echo 'Post schema created';
	}

	public function create()
	{
		// Load Doctrine library
		//$this->load->library('doctrine');
		
		// Create new post
//		$post = new Post;
//		$post->title('Example post');
//		$post->content('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');
//		$post->visits(0);
//
//		// Save post in db
//		$this->doctrine->em->persist($post);
//		$this->doctrine->em->flush();

        $data = [
            'title' => 'Tieeu ',
            'content' => 'Nội dung',
        ];
        $this->PostManager->create($data);
		
		echo 'Post created';
	}
	
	public function find($id)
	{

        $post = $this->PostManager->find($id);
        echo "<pre>";
        print_r($post);
		// Show post
		if ($post) {
//			$post->addVisit();
//			$this->doctrine->em->persist($post);
//			$this->doctrine->em->flush();
			$this->theme->load('post', array('post' => $post));
            //$this->parser->parse('post', array('post' => $post));
		}
		
		else
			show_404();
	}
	
	public function remove($id)
	{

		// Remove post
		if ($this->PostManager->remove($id)) {
			echo 'Post removed';
		}
		
		else
			show_404();
	}
	

}

/* End of file posts.php */
/* Location: ./application/modules/blog/controllers/posts.php */