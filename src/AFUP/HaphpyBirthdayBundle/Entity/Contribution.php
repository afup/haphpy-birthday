<?php

namespace AFUP\HaphpyBirthdayBundle\Entity;

/**
 * Contribution
 *
 * @author Faun <woecifaun@gmail.com>
 */
class Contribution
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fileName;

    /**
     * The origin of the authentication
     * i.e. GitHub, Facebook, Twitter
     *
     * @var string
     */
    private $authProvider;

    /**
     * The identifier
     * depends on the Auth Provider
     *
     * @var string
     */
    private $identifier;

    /**
     * Whether or not the person wants to be credited on the website
     *
     * @var bool
     */
    private $websiteCreditWanted;

    /**
     * Whether or not the person wants to be credited on video credits
     *
     * @var bool
     */
    private $videoCreditWanted;

    /**
     * The time assets was uploaded
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * The time assets was modified or reuploaded
     *
     * @var \DateTime
     */
    private $modifiedAt;

    /**
     * if the uploaded is validated
     *
     * @var bool
     */
    private $validated;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->createdAt  = new \DateTime();
        $this->modifiedAt = new \DateTime();
    }


    /**
     * Get the value of FileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of FileName
     *
     * @param string $fileName
     *
     * @return self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of The origin of the authentication
     *
     * @return string
     */
    public function getAuthProvider()
    {
        return $this->authProvider;
    }

    /**
     * Set the value of The origin of the authentication
     *
     * @param string $authProvider
     *
     * @return self
     */
    public function setAuthProvider($authProvider)
    {
        $this->authProvider = $authProvider;

        return $this;
    }

    /**
     * Get the value of The identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set the value of The identifier
     *
     * @param string $identifier
     *
     * @return self
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get the value of Whether or not the person wants to be credited on the website
     *
     * @return bool
     */
    public function isWebsiteCreditWanted()
    {
        return $this->websiteCreditWanted;
    }

    /**
     * Set the value of Whether or not the person wants to be credited on the website
     *
     * @param bool $websiteCreditWanted
     *
     * @return self
     */
    public function setWebsiteCreditWanted($websiteCreditWanted)
    {
        $this->websiteCreditWanted = $websiteCreditWanted;

        return $this;
    }

    /**
     * Get the value of Whether or not the person wants to be credited on video credits
     *
     * @return bool
     */
    public function isVideoCreditWanted()
    {
        return $this->videoCreditWanted;
    }

    /**
     * Set the value of Whether or not the person wants to be credited on video credits
     *
     * @param bool $videoCreditWanted
     *
     * @return self
     */
    public function setVideoCreditWanted($videoCreditWanted)
    {
        $this->videoCreditWanted = $videoCreditWanted;

        return $this;
    }

    /**
     * Get the value of The time assets was uploaded
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of The time assets was uploaded
     *
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of if the uploaded is validated
     *
     * @return bool
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * Set the value of if the uploaded is validated
     *
     * @param bool $validated
     *
     * @return self
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }


    /**
     * Gets the value of id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param int $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the time assets was modified or reuploaded.
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Sets the time assets was modified or reuploaded.
     *
     * @param \DateTime $modifiedAt the modified at
     *
     * @return self
     */
    public function setModifiedAt(\DateTime $modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }
}
