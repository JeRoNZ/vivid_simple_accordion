<?php 
namespace Concrete\Package\SimpleAccordion\Block\VividSimpleAccordion;
use \Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Loader;

class Controller extends BlockController
{
    protected $btTable = 'btVividSimpleAccordion';
    protected $btInterfaceWidth = "700";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "465";

    public function getBlockTypeDescription()
    {
        return t("Add Collapsible Content to your Site");
    }

    public function getBlockTypeName()
    {
        return t("Simple Accordion");
    }

    public function add()
    {
		if (version_compare(\Config::get('concrete.version'), '8.0', '<')) {
			$this->requireAsset('redactor');
		}
    }

    public function edit()
    {
		if (version_compare(\Config::get('concrete.version'), '8.0', '<')) {
			$this->requireAsset('redactor');
		}
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividSimpleAccordionItem WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $this->set('items', $items);
    }

    public function view()
    {
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividSimpleAccordionItem WHERE bID = ? ORDER BY sortOrder', array($this->bID));

		foreach($items as &$i) {
			$i['description'] = LinkAbstractor::translateFrom($i['description']);
		}

        $this->set('items', $items);
        $this->requireAsset('css', 'font-awesome');
        switch($this->semantic){
            case "h2":
            case "h3":
            case "h4":
            case "h5":
            case "h6":
            case "h7":
            case "span":
                $openTag = "<{$this->semantic} class='panel-title'>";
                $closeTag = "</{$this->semantic}>";
                break;
            case "paragraph":
                $openTag = "<p class='panel-title'>";
                $closeTag = "</p>";
                break;
        }
        $this->set("openTag",$openTag);
        $this->set("closeTag",$closeTag);
    }

    public function duplicate($newBID) {
        parent::duplicate($newBID);
        $db = Loader::db();
        $v = array($this->bID);
        $q = 'select * from btVividSimpleAccordionItem where bID = ?';
        $r = $db->query($q, $v);
        while ($row = $r->FetchRow()) {
            $db->execute('INSERT INTO btVividSimpleAccordionItem (bID, title, description, state, sortOrder) values(?,?,?,?,?)',
                array(
                    $newBID,
                    $args['title'][$i],
                    $args['description'][$i],
                    $args['state'][$i],
                    $args['sortOrder'][$i]
                )
            );
        }
    }

    public function delete()
    {
        $db = Loader::db();
        $db->delete('btVividSimpleAccordionItem', array('bID' => $this->bID));
        parent::delete();
    }

    public function save($args)
    {
        $db = Loader::db();
        $db->execute('DELETE from btVividSimpleAccordionItem WHERE bID = ?', array($this->bID));
        $count = count($args['sortOrder']);
        $i = 0;
        parent::save($args);
        while ($i < $count) {
			$description = LinkAbstractor::translateTo($args['description'][$i]);

            $db->execute('INSERT INTO btVividSimpleAccordionItem (bID, title, description, state, sortOrder) values(?,?,?,?,?)',
                array(
                    $this->bID,
                    $args['title'][$i],
                    $description,
                    $args['state'][$i],
                    $args['sortOrder'][$i]
                )
            );
            $i++;
        }
        $blockObject = $this->getBlockObject();
        if (is_object($blockObject)) {
            $blockObject->setCustomTemplate($args['framework']);
        }
    }
    

}
