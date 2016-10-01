<?php
/**
 * Class WebdaweTimeline
 */
include_once WEBDAWE_PLUGIN_DIR . 'classes/WebdaweBase.php';

class WebdaweTimeline extends WebdaweBase
{
	private $db;
	private $timelineData = array();
	private $entryData = array();
	private $loaded = false;

    private $data = array();

    private $table = 'webdawe_timeline';
    /**
     * Settable Properties
     * @var array
     */
    protected $settable = array('title', 'description','style');

    /**
     * Gettable Properties
     * @var array
     */
    protected $gettable = array('title', 'description','style');


    /**
	 * Constructor
	 * @param object $db Connection
	 * @param  int $timelineId
	 */
	public function __construct($db, $timelineId = null)
	{
		$this->db = $db;

		if ($timelineId)
		{
			$this->load($timelineId);
		}
	}

     /**
     * Retrieve Timeline List
     * @return mixed
     */
	public function getTimelineList()
    {
        $query = 'SELECT * FROM ' . $this->db->prefix .'webdawe_timeline';
        $result = $this->db->get_results($query);

        return $result;
    }

    /**
     * Retrieve timeline
     * @param int $timelineId
     * @return mixed
     */
    public function loadTimeline($timelineId)
    {

        $query  = $this->db->prepare('SELECT * FROM ' . $this->db->prefix. $this->table .' WHERE id= %d ', $timelineId);
        $result = $this->db->get_results($query);

        foreach ($result as $key => $row)
        {

            $this->setId($row->id);
            $this->setTitle($row->title);
            $this->setDescription(stripslashes($row->description));
            $this->setStyle($row->style);
        }
    }

    public function save()
    {

        $data =  array( 'title' => sanitize_text_field($this->getTitle()),
                        'description' => wp_kses_post($this->getDescription()),
                        'style' => $this->getStyle(),
                    );
        if ($id = $this->getId())
        {
            $this->db->update(
                $this->db->prefix .$this->table,
                $data,
                array( 'id' => $id)
            );
        }
        else
        {
            $this->db->insert( $this->db->prefix .$this->table, $data);
        }
    }
	/**
	 * Load Timeline
	 * @param  int $timelineId
	 */
	public function load($timelineId)
	{
		
		try
		{
			$query = 'SELECT t.title AS timeline_title, t.description as timeline_description,t.style,
					  e.time,e.title AS entry_title, e.description as entry_description,
					  e.gallery_id 	 
					  FROM ' . $this->db->prefix .'webdawe_timeline_entry e 
					  LEFT JOIN ' . $this->db->prefix .'webdawe_timeline t  ON t.id = e.timeline_id 
					  WHERE t.id=' . $timelineId;

			$result = $this->db->get_results($query);

            $this->timelineData = array();
            $this->entryData = array();

            if (!$result)
			{
				$this->loaded = false;
			}

			foreach ($result as $key => $row)
			{
				if ($key == 0)
				{
					$this->title = $row->timeline_title;
					$this->description = $row->timeline_description;
					$this->style     = $row->style;
				}
				
				$this->entryData[] = array('time' => $row->time,
											'title' => $row->entry_title,
											'description' => $row->description,
											'gallery_id' => $row->gallery_id
										);

			}

			$this->loaded = true;
		}
		catch (Exception $error)
		{
			$this->loaded = false;
		}

	}

	/**
	 * Retrieve Timeline Data
	 * @return array
	 */
	
	public function getTimelineEntries()
	{
		return $this->entryData;
	}
}
