<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Widget_Dashboard_RSS extends Model_Widget_Decorator_Dashboard {	
	
	/**
	 *
	 * @var boolean
	 */
	protected $_multiple = TRUE;
	
	protected $_data = array(
		'limit' => 10
	);
	
	public function set_rss_url($url) 
	{
		if (!Valid::url($url))
		{
			return NULL;
		}

		return $url;
	}
	
	public function set_limit($limit) 
	{
		return (int) $limit;
	}
	
	public function fetch_data()
	{
		$cache = Cache::instance();
		
		$data = $cache->get($this->id);
		if($data === NULL)
		{
			$data = Feed::parse($this->rss_url, $this->limit);
			$cache->set($this->id, $data, Date::MINUTE * 10);
		}
		
		$data['rss_url'] = $this->rss_url;
		
		return $data;
	}
}