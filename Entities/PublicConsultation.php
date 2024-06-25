<?php

namespace PublicConsultation\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use MapasCulturais\App;

/**
 * Link 
 * 
 * @ORM\Table(name="public_consultation")
 * @ORM\Entity
 * @ORM\entity(repositoryClass="PublicConsultation\Repositories\PublicConsultation")
 */
class PublicConsultation extends \MapasCulturais\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="public_consultation_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="text", nullable=false)
     */
    protected $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="google_docs_link", type="string", nullable=false)
     */
    protected $googleDocsLink;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    protected $status = self::STATUS_ENABLED;

    /**
     * @var \MapasCulturais\Entities\Agent
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\Agent", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    protected $owner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_timestamp", type="datetime", nullable=false)
     */
    protected $createTimestamp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_timestamp", type="datetime", nullable=true)
     */
    protected $updateTimestamp;

    public function create($data)
    {
        $app = App::i();

        $this->title = $data["title"];
        $this->subtitle = $data["subtitle"];
        $this->googleDocsLink = $data["google_docs_link"];
        $this->owner = $app->getUser()->profile;
        $this->createTimestamp = new DateTime();

        $this->save(true);
    }

    public function update($data)
    {
        $app = App::i();

        $this->title = $data["title"];
        $this->subtitle = $data["subtitle"];
        $this->googleDocsLink = $data["google_docs_link"];
        $this->status = (int) $data["status"];
        $this->owner = $app->getUser()->profile;
        $this->updateTimestamp = new DateTime();

        $this->save(true);
    }

    public function trash()
    {
        $app = App::i();

        $this->status = self::STATUS_TRASH;
        $this->owner = $app->getUser()->profile;
        $this->updateTimestamp = new DateTime();

        $this->save(true);
    }
}
