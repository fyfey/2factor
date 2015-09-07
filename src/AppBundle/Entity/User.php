<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements TwoFactorInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer $twoFactorCode Current authentication code
     * @ORM\Column(type="integer", nullable=true)
     */
    private $twoFactorCode;

    public function __construct()
    {
        parent::__construct();
    }

    public function isEmailAuthEnabled() {
        return true;
    }

    public function getEmailAuthCode() {
        return $this->twoFactorCode;
    }

    public function setEmailAuthCode($twoFactorCode) {
        $this->twoFactorCode = $twoFactorCode;
    }
}
