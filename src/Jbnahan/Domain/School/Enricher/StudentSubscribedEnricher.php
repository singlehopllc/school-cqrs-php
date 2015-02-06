<?php
/**
 * @author Jean-Baptiste Nahan <jean-baptiste@nahan.fr>
 * @license MIT
 */

namespace Jbnahan\Domain\School\Enricher;

use Broadway\Domain\Metadata;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricherInterface;
use Doctrine\ORM\EntityManager;


class StudentSubscribedEnricher implements MetadataEnricherInterface {
	private $em;
	private $event;

	public function __construct(EntityManager $em){

		$this->em = $em;
	}

	public function enrich(Metadata $metadata){
		$obj = $this->em->getRepository("JbnahanSchoolBundle:StudentsClass")->findOneBy(array('id'=>$this->event->classId));
        $data = array(
            'fullname' => (string) $obj
        );
        $newMetadata = new Metadata($data);
        return $metadata->merge($newMetadata);
    }

    public function setEvent($event){
    	$this->event = $event;
    }
}