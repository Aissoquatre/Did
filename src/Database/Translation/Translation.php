<?php

namespace Did\Database\Translation;

/**
 * Class Translation
 *
 * @package Did\Database\Translation
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class Translation extends TranslationRepository
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string
     */
    protected $tKey;

    /**
     * @var string
     */
    protected $fr;

    /**
     * @var string
     */
    protected $en;

    /**
     * @var string
     */
    protected $es;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Translation
     */
    public function setId(int $id): Translation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTKey(): string
    {
        return $this->tKey;
    }

    /**
     * @param string $tKey
     * @return Translation
     */
    public function setTKey(string $tKey): Translation
    {
        $this->tKey = $tKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getFr(): string
    {
        return $this->fr;
    }

    /**
     * @param string $fr
     * @return Translation
     */
    public function setFr(string $fr): Translation
    {
        $this->fr = $fr;
        return $this;
    }

    /**
     * @return string
     */
    public function getEn(): string
    {
        return $this->en;
    }

    /**
     * @param string $en
     * @return Translation
     */
    public function setEn(string $en): Translation
    {
        $this->en = $en;
        return $this;
    }

    /**
     * @return string
     */
    public function getEs(): string
    {
        return $this->es;
    }

    /**
     * @param string $es
     * @return Translation
     */
    public function setEs(string $es): Translation
    {
        $this->es = $es;
        return $this;
    }
}